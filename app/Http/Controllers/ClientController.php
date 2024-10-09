<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\ClientMovementController;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    public function index(){

        if(!auth()->user()->superuser){
            return redirect()->route('sys.home');
        }

        return view('pages.client.index');
    }

    public function getClients(Request $request){

        if(!auth()->user()->superuser){
            return response()->json([
                'message' => "No tienes los permisos para realizar esta operación",
                'code' => 500,
            ]);
        }

        if(isset($request->search)){
            $search = $request->search;
            $clients = Client::select(
                '*', 
                DB::raw('CONCAT(company, " - ", name, " ", lastname) AS alias')
            )
            ->where(function($query) use($search){
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('lastname', 'like', '%'.$search.'%')
                ->orWhere('company', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('rfc', 'like', '%'.$search.'%')
                ->orWhere('regime', 'like', '%'.$search.'%')
                ->whereNull('deleted_at');
            })->latest();
        }else{
            $clients = Client::select(
                '*', 
                DB::raw('CONCAT(company, " - ", name, " ", lastname) AS alias')
            )
            ->latest();
        }

        return $clients->paginate(10);

    }


    public function getClientsPluck(Request $request){

        try {

            $clients = Client::select(
                'id AS value',
                DB::raw('CONCAT(company, " - ", name, " ", lastname) AS text')
            )
            ->where('company', 'LIKE', '%'.$request->search.'%')
            ->orWhere('name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('lastname', 'LIKE', '%'.$request->search.'%')
            ->take(50)
            ->get();

            return response()->json([
                'data' => $clients,
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }


    public function getClient(Request $request){

        if(!auth()->user()->superuser){
            return response()->json([
                'message' => "No tienes los permisos para realizar esta operación",
                'code' => 500,
            ]);
        }

        return Client::find($request->id);

    }

    public function store(Request $request){

        try {

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }
            
            // Validación
            $this->validate($request, [
                'name' => 'required|max:200',
                'lastname' => 'required|max:200',
                'company' => 'required|max:200',
                'phone' => 'required|max:20',
                'rfc' => 'required|max:50',
                'regime' => 'required|max:200'
            ]);

            if(isset($request->id)){
                $client = Client::find($request->id);
            }else{
                $client = new Client();
            }

            $client->name = strtoupper($request->name);
            $client->lastname = strtoupper($request->lastname);
            $client->company = strtoupper($request->company);
            $client->phone = strtoupper($request->phone);
            $client->rfc = strtoupper($request->rfc);
            $client->regime = strtoupper($request->regime);
            $client->save();
    
            return response()->json([
                'message' => "¡Se guardo el cliente correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }

    public function delete(Request $request){

        try {

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }

            $client = Client::find($request->id);
            $client->delete();

            return response()->json([
                'message' => "¡Cliente eliminado correctamente!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }

    public function payBalance(Request $request){

        try {

            // Validación
            $this->validate($request, [
                'balance' => 'required|min:1',
                'pay_date' => 'required|date'
            ]);

            if(!auth()->user()->superuser){
                return response()->json([
                    'message' => "No tienes los permisos para realizar esta operación",
                    'code' => 500,
                ]);
            }
            
            // Create client movement
            $result = ClientMovementController::createClientMovement(
                $request->id, 
                'ABONO', 
                $request->pay_date, 
                $request->balance
            );

            if($result->code == 500){
                return response()->json([
                    'message' => "Ocurrió un error al procesar los datos. ".$result->message,
                    'code' => 500,
                ]);
            }

            return response()->json([
                'message' => "¡Movimiento realizado con exito!",
                'code' => 200,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
            ]);
        }

    }
    


}
