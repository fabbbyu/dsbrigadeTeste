<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class NoticiaController extends Controller
{
    public function index(){
        return view('lista');
    }

    public function list(Request $request){

        $gets = $request->all();

        $draw = $gets['draw'];
        $row = $gets['start'];
        $rowperpage = $gets['length']; // Rows display per page
        $columnIndex = $gets['order'][0]['column']; // Column index
        $columnName = $gets['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $gets['order'][0]['dir']; // asc or desc
        $searchValue = $gets['search']['value']; // Search value

        ## Total number of records without filtering     
        $totalRecords = count(Noticia::all());

        ## Total number of record with filtering
        if(!empty($searchValue)){
            $totalRecordwithFilter = count(
                                            DB::table('noticias')
                                                ->where('titulo', 'like', '%'.$searchValue.'%')
                                                ->orWhere('fonte', 'like', '%'.$searchValue.'%')
                                                ->orWhere('url', 'like', '%'.$searchValue.'%')
                                                ->orWhere('subtitulo', 'like', '%'.$searchValue.'%')
                                                ->orWhere('data_pub', 'like', '%'.$searchValue.'%')
                                                ->orWhere('data_coleta', 'like', '%'.$searchValue.'%')
                                                ->orWhere('texto', 'like', '%'.$searchValue.'%')
                                                ->orWhere('tags', 'like', '%'.$searchValue.'%')
                                                ->get()
                                          );
        }else{
            $totalRecordwithFilter = $totalRecords;
        }   


        $noticias = DB::table('noticias')
                        ->where('titulo', 'like', '%'.$searchValue.'%')
                        ->orWhere('fonte', 'like', '%'.$searchValue.'%')
                        ->orWhere('url', 'like', '%'.$searchValue.'%')
                        ->orWhere('subtitulo', 'like', '%'.$searchValue.'%')
                        ->orWhere('data_pub', 'like', '%'.$searchValue.'%')
                        ->orWhere('data_coleta', 'like', '%'.$searchValue.'%')
                        ->orWhere('texto', 'like', '%'.$searchValue.'%')
                        ->orWhere('tags', 'like', '%'.$searchValue.'%')
                        ->orderBy($columnName, $columnSortOrder)
                        ->offset($row)
                        ->limit($rowperpage)
                        ->get();        

        $data = array();

        foreach($noticias as $noticia){

            $noticia->data_pub = date('d/m/Y', strtotime($noticia->data_pub));
            $noticia->data_coleta = date('d/m/Y', strtotime($noticia->data_coleta));  
            $textoCompleto = $noticia->texto;

            if(mb_strlen($noticia->texto, 'UTF-8') > 30){
                $noticia->texto = mb_substr($noticia->texto, 0, 30, 'UTF-8')."...";
                
            }

            array_push($data, array(
                'id' => $noticia->id,
                'titulo' => $noticia->titulo,
                'fonte' => $noticia->fonte,
                'url' => $noticia->url,
                'subtitulo' => $noticia->subtitulo,
                'data_pub' => $noticia->data_pub,
                'data_coleta' => $noticia->data_coleta,
                'texto' => '<p title="'.$textoCompleto.'">'.$noticia->texto."</p>",
                'tags' => json_decode($noticia->tags),
                'button' => '<a href="'.$noticia->url.'" target="_blank" class="btn btn-primary">Acessar</a>'
               
            ));
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        return response()->json($response);

    }

}
