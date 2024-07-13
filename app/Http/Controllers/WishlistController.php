<?php

namespace App\Http\Controllers;
use App\Models\Tiket;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(){ //show all wishlist of current user
        $title = "Wishlist";
        //get all wishlist that belongs to currently logged in user
        $wishlistItems = Wishlist::where('id_pembeli', session('user')->id_pembeli)->get(); //array
        $allTickets = Tiket::all(); //get all tickets []
        $tempTickets = []; //to store all tickets that belong to the wishlist
        foreach ($wishlistItems as $wishItem){
            foreach ($allTickets as $ticket){
                if ($ticket->id_tiket == $wishItem->id_tiket && $wishItem->status == '1'){
                    array_push($tempTickets, $ticket);
                }
            }
        }
        return view('wishlist', compact('wishlistItems','title','tempTickets')); //equivalent to with(["wishlistItems"->$wishlistItems]) but more compact
    }

    public function addToWishlist($id){
        $user = session('user');
        //if user hasnt logged in, redirect to login page
        if (!$user) {
            return redirect('/login');
        }
        // Check if the item is already in the wishlist
        //get wishlists to be checked
        $tempWishlists = Wishlist::where('id_pembeli', $user->id_pembeli)->get();
        foreach ($tempWishlists as $temp){
            if ($temp->id_tiket == $id && $temp->status == 1){
                //already in the wishlist
                return redirect('/home')->with('message', 'Item is already in your wishlist');
            }
        }
        //if item not exist in the wishlist, add it right away
        $ctr = Wishlist::count()+1;
        $numberWithLeadingZeros = str_pad($ctr, 3, '0', STR_PAD_LEFT);
        $newId = "WL".$numberWithLeadingZeros;
        //insert to database
        Wishlist::create([
            'id_wishlist'=> $newId ,
            'id_pembeli' => session('user')->id_pembeli,
            'id_tiket' => $id,
        ]);
        return redirect('/home')->with('message', 'Item added to your wishlist');
    }

    public function removeAllFromWishlist(){//remove all wishlists that belong to that user 
        //get the id of currently logged in user
        $id_user = session('user')->id_pembeli;
        Wishlist::where('id_pembeli', $id_user)->update([
            'status' => 0 //soft delete by changing only the status
        ]);

        //redirect with a message
        return redirect('/home')->with('message','Successfully removed all items from wishlist');
    }

    public function removeFromWishlist($id){ //accepting id_wishlist as a param
        // dd($id);
        //remove individual item from wishlist
        Wishlist::where('id_wishlist',$id)->update(["status"=>0]);
        return redirect("/wishlist");
    }
}
