<?php
declare(strict_types=1);
namespace SSG;//SSG: static site generator

require_once(__DIR__ . '/lib/utils.php');
use function Utils\create_dir;
use function Utils\join_paths;
use function Utils\read_json;
use function Utils\render_template;
use function Utils\copy_files;

require_once(__DIR__ . '/lib/table.php');
use Table\Table;

//---------------------------------------------------

//FUNCION INDEX
function make_index_html(string $template_index_filename, array $array_bookstores): void
{
    $filename_html = "../public/index.html";
    $template_vars = ['array_bookstores' => $array_bookstores];
    $end_index = render_template($template_index_filename, $template_vars);
    file_put_contents($filename_html, $end_index);
}

function make_img_page(string $template_img_filename, array $array_img, array $make_text_links): void
{
    $filename_html = "../public/img.html";
    $template_vars = [
        'array_img' => $array_img,
        'make_text_links'   => $make_text_links
    ];
    $end_index = render_template($template_img_filename, $template_vars);
    file_put_contents($filename_html, $end_index);
}

function make_tabla_page(string $template_tabla_filename)
{

    $table = Table::leer_csv('../db/juegos.csv');

    // $juegos_str = file_get_contents('../db/juegos.csv');
    // Let's make the table
    // $table = [];
    // $line_array = explode("\n", $juegos_str);
    // foreach($line_array as $line) {
    //     //array de cada campo
    //     $row = explode(",", $line);
    //     array_push($table, $row);
    // }

    $filename_html = "../public/table.html";
    $template_vars = [
        'table' => $table,
    ];
    $end_index = render_template($template_tabla_filename, $template_vars);
    file_put_contents($filename_html, $end_index);

}

function make_blog_page(array $file_array, string $blog_tamplate){
    $blog_template_filename = $blog_tamplate;
    $filename_html = "../public/blog.html";
    $template_vars  = ['file_array' => $file_array];
    $index_contents = render_template($blog_template_filename, $template_vars);

    file_put_contents($filename_html, $index_contents);
}

function make_api_page(array $games_array, string $api_template){
    $api_template_filename = $api_template;
    $filename_html = "../public/api.html";
    $template_vars  = ['games_array' => $games_array];
    $index_contents = render_template($api_template_filename, $template_vars);

    file_put_contents($filename_html, $index_contents);
}

//----------------------------------------
function main(): void
{
    //Cleanup the public/ dir (DANGEROUS!)
    shell_exec("rm -r -f ../public/*");

    //Create public dir structure
    create_dir('../public');
    create_dir('../public/img');
    create_dir('../public/css');
    create_dir('../public/img_html');

    // 1. List files
    $local_file_array = glob('../resources/img/*');
    $local_img_html_array = glob('../resources/img_html/*');

    // 2. Filter and keep only image files
    $check_is_image    = fn ($file) => preg_match('~(jpg|png)$~i', basename($file));
    $local_image_array = array_values(array_filter($local_file_array, $check_is_image));

    // 3. Rewrite paths
    $make_web_link   = fn ($file) => join_paths('./img/', basename($file));
    $web_image_array = array_map($make_web_link, $local_image_array);

    // 4. Create text links
    $array_img       = read_json('../db/imagenes.json');
    $make_text_links = [];
    foreach($array_img as $img){
        $img_name = 'img_html/' . $img . '/' . $img . '.html';
        array_push($make_text_links, $img_name);
    }

    // 5. Fill template
    $index_template_filename = "template/img.template.php";
    $template_vars  = [
        'array_img'  => $web_image_array,
        'make_text_links' => $make_text_links
    ];
    $img_contents = render_template($index_template_filename, $template_vars);

    // 8. Write index.html
    $img_filename = "../public/img.html";
    file_put_contents($img_filename, $img_contents);

    // 9. Copy files to public/ dir
    copy_files(['../resources/favicon.ico'], '../public/');
    copy_files($local_image_array,      '../public/img/');
    copy_files(['../resources/css/style.css'], '../public/css');
    copy_files(['../resources/css/practica.css'], '../public/css');
    copy_files(['../resources/css/img_style.css'], '../public/css');
    copy_files(['../resources/css/css_blog.css'], '../public/css');

    shell_exec("cp -r ../resources/img_html/* ../public/img_html");
    
    

    $array_bookstores           = read_json('../db/empresas.json');
    $template_index_filename    = "template/template.index.php";
    $template_img_filename      = "template/img.template.php";
    $template_tabla_filename    = "template/template.tabla.php";
    $template_api_filename      = "template/api.template.php";

    Make_index_html($template_index_filename, $array_bookstores);
    make_img_page($template_img_filename, $web_image_array, $make_text_links);
    make_tabla_page($template_tabla_filename);

    //_____________blog_______________
    $file_array = [];
    $blog_tamplate = "template/template.blog.php";

    $local_file_array1 = file_get_contents('noticias/2022-10-25.txt');
    $local_file_array2 = file_get_contents('noticias/2022-10-30.txt');
    $local_file_array3 = file_get_contents('noticias/2022-10-31.txt');
    $local_file_array4 = file_get_contents('noticias/2022-11-01.txt');
    

    array_push($file_array, $local_file_array4);
    array_push($file_array, $local_file_array2);
    array_push($file_array, $local_file_array1);
    array_push($file_array, $local_file_array3);

    //___________ORDENADO_____________
    sort($file_array);
    print_r($file_array);

    make_blog_page($file_array, $blog_tamplate);

    //VALIDAR API
    // $json_String = shell_exec("curl 'https://www.freetogame.com/api/games'");
    // echo $json_String;
    // $games_array = json_decode($json_String, true);

    // print_r($games_array);

    // make_api_page($games_array, $template_api_filename);
};

main();