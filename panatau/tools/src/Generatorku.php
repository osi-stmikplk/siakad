<?php
/**
 * Untuk memudahkan generator beberapa hal yang asyik
 * User: toni
 * Date: 17/10/15
 * Time: 19:32
 */

namespace Panatau\Tools;


use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Generatorku extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generatorku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To generate my needs.';

    /**
     * @var string environment of our database
     */
    protected $environment = 'mysql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->getDBEnvironment();
        $fields = $this->getFieldsOf($this->argument('table'));
        if($this->option('rules'))
        {
            // generate rules
            $rules = $this->generateRules($fields);
            echo $rules;
        }
        elseif($this->option('detail'))
        {
            // generate untuk detail
            $detail = $this->generateDetail($fields);
            echo $detail;
        }
        elseif($this->option('forcedate'))
        {
            echo $this->forceDateFormat($fields);
        }
        else
        {
            // generate form
            $st = $this->buildForm($fields);
            echo $st;
        }
    }

    protected function getDBEnvironment()
    {
        if($this->option('dbenv'))
        {
            $this->environment = $this->option('dbenv');
        }
    }

    protected function getFieldsOf($tableName)
    {
        $arr = [];

        switch($this->environment)
        {
            case 'mysql': $infoColumns = \DB::select(\DB::raw('SHOW COLUMNS FROM '.$tableName)); break;
            case 'sqlite': $infoColumns = \DB::select(\DB::raw('pragma table_info('.$tableName).')'); break;
        }

        foreach($infoColumns as $info)
        {
            if($this->environment=='mysql')
            {
                $arr[] = [
                    'field' => $info->Field,
                    'type' => $info->Type,
                    'required' => strcasecmp($info->Null, 'NO') === 0 ? true: false,
                ];
            }
            elseif($this->environment=='sqlite')
            {
                $arr[] = [
                    'field' => $info->name,
                    'type' => $info->type,
                    'required' => $info->notnull
                ];
            }
        }
        return $arr;
    }

    /**
     * Buat generate template untuk form
     * @param array $fields
     * @return string
     */
    protected function buildForm(array $fields)
    {
        $c = <<<B
<form onsubmit="return PANATAU.onsubmitIt(this, event, onSubmitSuccess);"
    class="form-horizontal" role="form" method="POST" action="{{ \$action }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="{{ \$method }}">
B;

        foreach ($fields as $field) {
            $label = $this->generateLabel($field['field']);
            $maxlength = $this->generateMax($field['type']);
            $b = <<<B
    <div class="form-group">
        <label for="{$field['field']}" class="col-md-3 control-label">{$label}</label>
        <div class="col-md-9">
            <input type="text" id="{$field['field']}" class="form-control" name="{$field['field']}"
                   value="{{ load_input_value(\$data, "{$field['field']}") }}"{$maxlength}>
            <div id="error-{$field['field']}" class="error"></div>
        </div>
    </div>
B;
            $c .= $b.PHP_EOL;
        }
        $c .=<<<B
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
</script>
B;
        return $c;
    }

    /**
     * Generate untuk label
     * @param string $fieldName
     * @return string
     */
    protected function generateLabel($fieldName)
    {
        $c = explode("_", $fieldName);

        return  ucwords(implode(" ", $c));
    }

    /**
     * Dapatkan nilai MAX dari sebuah field
     * @param string $fieldType
     * @return string
     */
    protected function generateMax($fieldType)
    {
        // multiple explode
        $fds = explode(' ', trim(str_replace(['(',')'],' ', $fieldType)));
//        var_dump($fds, count($fds));
        return count($fds) >1 ? " maxlength=\"{$fds[1]}\"":"";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'Table to generate!.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['rules', null, InputOption::VALUE_NONE, 'Generate rules bukan form.', null],
            ['detail', null, InputOption::VALUE_NONE, 'Generate html sintak untuk detail.', null],
            ['forcedate', null, InputOption::VALUE_NONE, 'Generate PHP untuk custom date di model.', null],
            ['dbenv', null, InputOption::VALUE_OPTIONAL, 'Pilihan Database Environment (default:mysql) : sqlite mysql']
        ];
    }

    /**
     * Generator untuk rules
     * @param array $fields
     * @return string
     */
    protected function generateRules($fields)
    {
        $c = '';
        foreach ($fields as $field) {
            $b = [];
            if($field['required']) $b[] = 'required';
            // push
            $type = explode(' ', trim(str_replace(['(',')'],' ', $field['type'])));
            switch(strtolower($type[0]))
            {
                case 'char':
                case 'varchar':
                    if(isset($type[1])) $b[] = "max:{$type[1]}"; // sqlite tidak ada panjang
                    break;
                case 'date':
                    $b[] = "date_format:d/m/Y"; // force indonesian version
                    break;
                case 'int':
                case 'integer':
                case 'tinyint':
                    $b[] = 'integer';
                    break;
                case 'decimal':
                    $b[] = 'numeric';
                    break;
            }
            if(count($b)>=1)
            {
                $ab = sprintf('"%s"=>"%s",', $field['field'], implode('|', $b) );
                $c .= $ab.PHP_EOL;
            }
        }
        return $c;
    }

    /**
     * Generate untuk detailnya
     * @param $fields
     * @return string
     */
    private function generateDetail($fields)
    {
        $c = '';
        foreach ($fields as $field) {
            $b = [];
            // 0 -> nama | 2 -> panjang (beberapa ndak ada=datetime)
            $type = explode(' ', trim(str_replace(['(',')'],' ', $field['type'])));
            $label = $this->generateLabel($field['field']);
            $b[] = "<td class=\"caption\">{$label}</td>";
            switch(strtolower($type[0]))
            {
                case 'char':
                case 'varchar':
                case 'integer':
                case 'int':
                case 'tinyint':
                case 'date':
                    $b[] = "<td>{{ \$data->{$field['field']} }}</td>";
                    break;
                case 'decimal':
                    $b[] = "<td>{{ number_format(\$data->{$field['field']},2) }}</td>";
                    break;
                default:
                    $b[] = "<td>{{ \$data->{$field['field']} }}</td>";
            }
            if(count($b)>=1)
            {
                $ab = "<tr>".implode(PHP_EOL, $b)."</tr>";
                $c .= $ab.PHP_EOL;
            }
        }
        return "<table class=\"table table-stripped\"><tbody>$c</tbody></table>";
    }

    /**
     * Generate untuk mendapatkan set dan get date property yang compatible dengan inputan local Indonesia.
     * @param $fields
     * @return string
     */
    protected function forceDateFormat($fields)
    {
        $c = '';
        foreach ($fields as $field) {
            $setPattern = '';
            $type = explode(' ', trim(str_replace(['(',')'],' ', $field['type'])));
            switch(strtolower($type[0]))
            {
                // kita hanya akan melakukan proses terhadap date
                case 'date':
                    $fieldName = $field['field'];
                    $fieldNameCC = ucfirst(Str::camel($fieldName));
                    $setPattern = <<<SET
\npublic function set{$fieldNameCC}Attribute(\$value)
{
    \$this->attributes['{$fieldName}'] = convert_date_to('d-m-Y', \$value);
}
public function get{$fieldNameCC}Attribute(\$value)
{
    return convert_date_to('Y-m-d', \$value, 'd-m-Y');
}
SET;
                    break;
                default:
                    // nothing to do ...
            }
            $c .= $setPattern;
        }
        return $c;
    }
}