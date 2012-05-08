<?php
@header('Content-Type: text/html; charset=utf-8');
require_once "includes.php";
require_once "ParserNoticias.php";
require_once "lib/simple_html_dom.php";


class GNewsClient {
	/**
	* Busca das not�cias publicadas no RSS com palavras presentes no prametro de pesquisa
	* @param String[] $parameters
	* 			Array com palavras a serem pesquisadas nos itens RSS
	*/
	public function search($parameters) {
		foreach($parameters as $searchWord) {
			//prepara query
			$encode = urlencode($searchWord);
			$url_search = $this->main_url.$encode;
			
			//carrega JSON 
			$result_json = $this->execSearch($url_search);
			if (!isset($result_json)){
				return; 
			}
			//Cria array com itens presentes no RSS consultado
			$output = json_decode($result_json);
			
			//Insere na Base de Dados e caracteriza semanticamente cada noticia encontrada
			foreach($output->responseData->results as $news) {
				$myNew = new Noticia(); 
				$myNew->setIdfonte($this->idfonte);
				$myNew->setData_pub(isset($news->publishedDate) ?
									Util::formatDateToDB($news->publishedDate)
									: "");
				$myNew->setAssunto(isset($news->titleNoFormatting) ?
									addslashes($news->titleNoFormatting)
									: "");
				$myNew->setDescricao(isset($news->content) ?
									addslashes($news->content)
									: "");
				@$myNew->setTexto(isset($news->unescapedUrl) ?
									addslashes(file_get_contents($news->unescapedUrl))
									: "");
				$myNew->setUrl(isset($news->unescapedUrl) ?
									addslashes($news->unescapedUrl)
									: ""); 
									echo 'wtf1';
				//$myNew->setTexto($myNew->fetchTexto($myNew->getUrl()));
				ParserNoticias::parseNoticia($myNew);
			}
		}
		echo "Foram inseridas not�cias da Fonte ".$this->getNome()." com sucesso.";
	}
	
	private function execSearch($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, "http://http://localhost/aw12/backend/");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		@$result= curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}


?>