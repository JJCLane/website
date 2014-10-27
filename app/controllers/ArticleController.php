<?php

use JordanLane\Website\Articles\ArticleCollection;

class ArticleController extends BaseController {

	/**
	 * Create a new home controller instance.
	 * 
	 * @param  \JordanLane\Website\Articles\ArticleCollection  $articles
	 * @return void
	 */
	public function __construct(ArticleCollection $articles)
	{
		$this->articles = $articles;
	}

	/**
	 * Read an individual article.
	 * 
	 * @param  string  $slug
	 * @return void
	 */
	public function getArticle($slug)
	{
		if ( ! $article = $this->articles->get($slug))
		{
			return 'Error';
		}

		$this->layout->title = $article->getMeta('title');
		$this->layout->nest('content', 'articles.single', compact('article'));
	}

}