<?php
declare(strict_types=1);

namespace Table;


//from comic-viewer/v3
//Copy 'utils.php into lib/utils.php'

require_once(__DIR__ . '/utils.php');

use function Utils\println;

use ClassesAsNameSpaces\json as ClassesAsNameSpacesJson;
use table\table as TableTable;
use Utils;
//---------------------------------------------------------------------------
class Table
{
    //properties
    public array $header;
    public array $body;

    //constructor
    public function __construct(array $header = [], array $body = [])
    {
        $this->header = $header;
        $this->body = $body;
    }

    //Other methodes

    //____________________toString___________________________
    public function __toString(): string {

        $string_table = '';
        $array = $this->header;

            $string_header = implode(',',$array);
            $string_table = $string_table . $string_header;

        $string_table = $string_table . PHP_EOL;

        foreach($this->body as $row){
            $string_body = implode(',',$row);
            $string_table = $string_table . $string_body . PHP_EOL;

        }

        return $string_table;
    }

    //_______________leeer_csv________________________________
    public static function leer_csv(string $csvTable): Table {
        
        // Leer fichero como string
        $contents_str = trim(file_get_contents($csvTable)); //trim: recorta tabla

        // Dividir cada línea y cada campo y guardar en $data
        $data = [];
        $line_array = explode("\n", $contents_str);

        foreach($line_array as $line) {
            //array de cada campo
            $field_array = explode(",", $line); //Explode: transforma string en array
            array_push($data, $field_array);
        }

        // Dividir $data en $header y $body.
        
        $header = $data[0];
        array_shift($data); // array_shift(): recorta la primera linea de una array. $data No devuelve nada.
        $body   = $data;

        // Crear la Tabla
        $table = new Table($header, $body);

        return $table;
    }

    //_____________________Escribir_csv________________________
    public static function write_csv($table){
        $table_str = (string) $table;
        file_put_contents('mangas_table.csv', $table_str);
    }

}

//test
function test_table(): void
{
    // $empty_table = new Table();
    //var_dump($empty_table);

    $header = ['Title', 'Volumes'];
    $body   = [
        ['Chainsaw JavaScript', 13],
        ['Attack on PHP',       27],
        ['Dragon CSS Z',        10],
        ['Apache piece',        70],

    ];

    //test general
    $manga_table = new Table($header, $body);
    echo $manga_table;

    //parametros
    $filename = "mangas.csv";
    // $write = ['yofukashi no uta','143'];

    //leer tabla
    $table = Table::leer_csv($filename);
    echo $table;

    $table_str = (string) $table;
    file_put_contents('fichero.csv', $table_str);

    table ::write_csv($table);

    //escribir tabla
    // $write_table = Table::write_csv($table, $write);
    // println($write_table);

}
//---------------------------------------------------------------------------
// main();
