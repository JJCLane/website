<?php namespace JordanLane\Website\Console;

use Illuminate\Console\Command;
use JordanLane\Website\Articles\ArticleCollection;

class ArticleRefreshCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'refresh:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the article cache';

    /**
     * Article collection instance.
     * 
     * @var \JordanLane\Website\ArticleCollection
     */
    protected $articles;

    /**
     * Create a new basset command instance.
     * 
     * @param  \JordanLane\Website\ArticleCollection  $articles
     * @return void
     */
    public function __construct(ArticleCollection $articles)
    {
        parent::__construct();

        $this->articles = $articles;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->comment('Refreshing article cache...');

        $this->articles->forgetCollectionCache() and $this->articles->registerCollectionCache();

        $this->info('Article cache has been successfully refreshed.');
    }

}