<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientMovementController extends Controller
{

    public function index(Request $request){

        if(isset($request->search)){
            $search = $request->search;
            $clientMovements = ClientMovement::where(function($query) use($search) {
                $query->where('client_movements.order_id', 'like', '%'.$search.'%')
                ->orWhere('client_movements.amount', 'like', '%'.$search.'%')
                ->orWhere('client_movements.movement_type', 'like', '%'.$search.'%');
            })
            ->where('client_movements.client_id', $request->id);
            if(isset($request->init_date) && isset($request->end_date)){
                $clientMovements->whereBetween('client_movements.movement_date', [$request->init_date, $request->end_date]);
            }
            $clientMovements->orderBy('client_movements.movement_date', 'DESC')
            ->orderBy('client_movements.id', 'DESC');
        }else{
            $clientMovements = ClientMovement::where('client_movements.client_id', $request->id);
            if(isset($request->init_date) && isset($request->end_date)){
                $clientMovements->whereBetween('client_movements.movement_date', [$request->init_date, $request->end_date]);
            }
            $clientMovements->orderBy('client_movements.movement_date', 'DESC')
            ->orderBy('client_movements.id', 'DESC');
        }

        return $clientMovements->paginate(10);

    }

    /**
     * Movements Types 'PEDIDO', 'CANCELACION', 'ABONO'
     */
    public static function createClientMovement($idClient, $type, $date, $amount, $idOrder=null){

        try {

            // Creation of new movement
            $movement = new ClientMovement();
            $movement->client_id = $idClient;
            $movement->order_id = $idOrder;
            $movement->movement_type = $type;
            $movement->movement_date = $date;
            $movement->amount = $amount;

            // Updating client balance
            $client = Client::find($idClient);
            if($type == 'PEDIDO'){
                $client->balance += $amount;
            }else{
                $client->balance -= $amount;
            }

            $client->save();
            $movement->save();

            return (object) [
                'message' => "Movimiento creado correctamente",
                'code' => 200
            ];
        } catch (\Exception $e) {
            return (object) [
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }

    }

}
