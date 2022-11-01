<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CommentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function nested_rate(Request $req){
        $this->validate($req, [
            'rate_id'   => 'required|numeric',
            'contant'   => 'required',
        ]);

        /**
         * add new comment.
         */

        $comment = new \App\Comment;
        $comment->contant = $req->input('contant');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        $page_comment = new \App\PageComment;
        $page_comment->comment_id = $comment->id;
        $page_comment->item_id = $req->input('rate_id');
        $page_comment->page = 'rate';
        $page_comment->save();

        return back()->with('success', 'Comment Sent.');
    }
    public function store(Request $req){
        $this->validate($req, [
            'contant'   => 'required',
            'page'      => 'required',
            'item_id'   => 'required|numeric'
        ]);

        /**
         * add new comment.
         */

        $comment = new \App\Comment;
        $comment->contant = $req->input('contant');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        $page_comment = new \App\PageComment;
        $page_comment->comment_id = $comment->id;
        $page_comment->item_id = $req->input('item_id');
        $page_comment->page = $req->input('page');
        $page_comment->save();

        return back()->with('success', 'Comment Sent.');


    }

    public function reply(Request $req){
        $this->validate($req, [
            'reply_to_id'    => 'required|numeric',
            'contant'       => 'required'
        ]);

        $comment = new \App\Comment;
        $comment->contant = $req->input('contant');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        $reply = new \App\Reply;
        $reply->reply_to_id = $req->input('reply_to_id');
        $reply->comment_id = $comment->id;
        $reply->save();

        return back()->with('success', 'Comment Sent.');
        
    }

    public function AdminReply(Request $req){
        return $this->reply($req);
    }
}
