<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $article;
    protected $comment;

    public function __construct(Article $article, Comment $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $msg = new SendMail('Добавлен новый комментарий к статье '.$this->article->name.'. Комментарий: '.$this->comment->text);
        Mail::send($msg);
    }
}