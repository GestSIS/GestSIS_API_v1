<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ArrayHelper;
use Validator;
use App\Exceptions\ApiException;

/**
 * Classe abstraite représentant le controlleur pour l'API
 */
abstract class ApiController extends Controller {
	// Par défaut, 1 jour de cache
	protected $cacheLifetime = 1440;
	protected $key;

	/**
	 * Constructeur général. Définit la clé du cache
	 */
	public function __construct(){
		if(Route::getCurrentRoute()){
			$this->key = Route::getCurrentRoute()->getName();
		}
	}

	/**
	 * @return boolean true si le contenu est en cache
	 */
	protected function isCached(){
		return Cache::has($this->key);
	}

	/**
	 * Mise en cache du contenu
	 * @param mixed $content Contenu à mettre en cache
	 */
	protected function setCache($content){
		Cache::put($this->key, $content, $this->cacheLifetime);
	}

	/**
	 * @return mixed Contenu du cache
	 */
	protected function getCache(){
		return $this->showResult(Cache::get($this->key));
	}

	/**
	 * Affiche le résultat sous format JSON
	 * @param  string $content Contenu à afficher
	 * @return Response
	 */
	protected function showResult($content, $changeKeyCase = true){
		$content = ($changeKeyCase ? ArrayHelper::changeKeyCaseRecursive($content) : $content);

		return response()->json($content);
	}

	/**
	 * Valide les paramètres start et limit
	 */
	protected function checkForValidLimiters($start, $limit, $max = 30){
		$validator = Validator::make(
						['start' => $start, 'limit' => $limit],
						['start' => 'required|integer|min:0',
						 'limit' => 'required|integer|min:1|max:'.$max]
		);

		if($validator->fails()){
			throw new ApiException('Invalid "start" or "limit" parameter');
		}
	}
}
