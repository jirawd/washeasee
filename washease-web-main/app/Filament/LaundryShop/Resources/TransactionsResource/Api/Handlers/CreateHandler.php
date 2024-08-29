<?php
namespace App\Filament\LaundryShop\Resources\TransactionsResource\Api\Handlers;

use App\Models\Inventory;
use App\Models\Machines;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\LaundryShop\Resources\TransactionsResource;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = TransactionsResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $model = new (static::getModel());
        $model->fill($request->all());

        // Set delivery date based on service type
        if ($request->service_type === 'self_service') {
            $model->delivery_date = date('Y-m-d'); // Same day-delivery
        } elseif ($request->service_type === 'pickup') {
            $model->delivery_date = $request->delivery_fee === 0
                ? date('Y-m-d', strtotime('+3 days')) // Standard pickup (3 days)
                : date('Y-m-d', strtotime('+1 day')); // Rush pickup (+1 day)
        } elseif ($request->service_type === 'pickup_and_delivery') {
            $model->delivery_date = $request->delivery_fee === 0
                ? date('Y-m-d', strtotime('+3 days')) // Standard pickup and delivery (3 days)
                : date('Y-m-d', strtotime('+1 day')); // Rush pickup and delivery (+1 day)
        }

        // Set payment status based on payment method
        $model->payment_status = $request->payment_method === "G-CASH" ? 'PAID' : 'UNPAID';

        // Save the model and proceed if successful
        if ($model->save()) {
            // Reserve the machine
            $machine = Machines::find($request->machine_id);
            if ($machine) {
                $machine->status = 'Reserve';
                $machine->save();
            }


            // Update inventory based on items in invoiceData
            foreach ($request->service_avail as $invoiceItem) {
                // Check if the item is an inventory item
                if (isset($invoiceItem['is_inventory_item']) && $invoiceItem['is_inventory_item'] === true) {
                    // Find the inventory item by ID
                    $inventoryItem = Inventory::where('id', $invoiceItem['inventory_item_id'])->first();

                    if ($inventoryItem) {
                        // Subtract the quantity
                        $inventoryItem->item_quantity -= $invoiceItem['inventory_item_quantity'];
                        $inventoryItem->save();
                    }
                }
            }

        }

        return static::sendSuccessResponse($model, "Created Successfully");
    }

}
