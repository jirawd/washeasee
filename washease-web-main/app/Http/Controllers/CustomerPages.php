<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Services;
use App\Models\Transactions;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPages extends Controller
{
    public function customer_login() {
        return view('customers.login');
    }

    public function customer_dashboard() {

        $title = 'Customer Dashboard';

        $customer_transactions_pending = Transactions::query()->where('customer_id', Auth::id())->where('status', 'PENDING')->count();
        $customer_transactions_processing = Transactions::query()->where('customer_id', Auth::id())->where('status', 'PROCESSING')->count();
        $customer_transactions_ready_for_pickup = Transactions::query()->where('customer_id', Auth::id())->where('status', 'READY FOR PICKUP')->count();
        $customer_transactions_completed = Transactions::query()->where('customer_id', Auth::id())->where('status', 'COMPLETED')->count();

        return view('customers.pages.dashboard', compact('title', 'customer_transactions_pending', 'customer_transactions_processing', 'customer_transactions_ready_for_pickup', 'customer_transactions_completed'));
    }

    public function customer_laundry_shop() {

        $title = 'Laundry Shops';
        $laundry_shops = User::with(['shops_rating'])->where('role', 'LaundryShop')->where('status', 'APPROVE')->get();

        return view('customers.pages.laundry-shops', compact('title', 'laundry_shops'));
    }

    public function customer_laundry() {

        $title = 'My Laundry';
        $user_laundry = Transactions::query()->where('customer_id', Auth::id())->get();

        return view('customers.pages.my-laundry', compact('title', 'user_laundry'));
    }

    public function customer_self_service() {

        $title = 'Self Service - Laundry';

        return view('customers.pages.transactions.laundry-self-service', compact('title'));
    }

    public function customer_pickup_delivery() {

        $title = 'Pickup & Delivery - Laundry';

        return view('customers.pages.transactions.laundry-pickup-delivery', compact('title'));
    }

    public function customer_pickup_only() {

        $title = 'Pickup Only - Laundry';

        return view('customers.pages.transactions.laundry-pickup-only', compact('title'));
    }

    public function close_shop(Request $request) {

        // Retrieve the authenticated user
        $user = Auth::user();
        $user->is_shop_closed = 0;
        $user->save();

        Notification::make()
            ->title('Shop is now Closed')
            ->body('Your shop now is not visible to customers.')
            ->send();

        return redirect()->back();

    }

    public function open_shop(Request $request) {
        // Retrieve the authenticated user
        $user = Auth::user();
        $user->is_shop_closed = 1;
        $user->save();

        Notification::make()
            ->title('Shop is now Opened')
            ->body('Your shop is now visible to customers')
            ->send();

        return redirect()->back();
    }

    public function my_profile($id) {
        return view('customers.pages.my-profile', compact('id'));
    }


}
