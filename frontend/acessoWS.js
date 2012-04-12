var ajax;

/**
 * Criar o objeto ajax que vai fazer a requisi��o
 */
function CreateAjaxObject() {
	if(window.XMLHttpRequest) {// Mozilla, Safari, Novos browsers...
		ajax = new XMLHttpRequest();
	} else if(window.ActiveXObject) {// IE antigo
		ajax = new ActiveXObject("Msxml2.XMLHTTP");
		if(!ajax) {
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	if(!ajax)// iniciou com sucesso
		alert("Seu navegador n�o possui suporte para esta aplica��o!");
}

/*
 * Envia os dados para a URL informada
 *
 * @param url Arquivo que ir� receber os dados
 * @param dados dados a serem enviados no formato querystring nome=valor&nome1=valor2
 * @param AjaxResponseFunction  vari�vel to tipo function(string) para receber a resposta do ajax
 */
function SendData(url, dados, AjaxResponseFunction) {
	CreateAjaxObject();
	if(ajax) {
		ajax.onreadystatechange = function trataResposta() {
			if(ajax.readyState == 4) {
				AjaxResponseFunction(ajax.status, ajax.responseText);
			}
		};
		//definir o tipo de m�todo
		ajax.open("POST", url, true);

		//definir o encode do conte�do
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");

		//tamanho dos dados enviados
		ajax.setRequestHeader('Content-length', dados.length);

		//enviar os dados
		ajax.send(dados);
	}
}

/**
 * Chama o webservice
 */
function CallWs() {
	/*
	    aqui passe os par�metros do m�todo.
	    no formato 'querystring'
	    ex:
	        nomeParam1=valor1&nomeParam2=valor2&nomeParamN=valorN

        Muita aten��o aqui, pois deve ser informado aqui os nomes dos par�metros
        que est�o definidos no wsdl.
        Uma boa olhada, com aten��o ao wsdl ir� te mostrar os par�metros,tipos e os nomes dos m�todos
        dispon�veis no m�todo ou web service
	*/

	var dados = '';
	//dados += 'ano=' + encodeURIComponent(txtAno.value);
	//dados += '&mes=' + encodeURIComponent(txtMes.value);
	//dados += '&dia=' + encodeURIComponent(txtDia.value);

	//aqui o caminho completo do webservice seguido do nome do m�todo
	SendData("http://localhost/webservice/noticias.php", dados, AjaxResponseFunction);
}

/**
 * tratar a resposta do servidor
 * @param status status da resposta
 * @response resposta do servidor
 */
function AjaxResponseFunction(status, response) {

    var divR = document.getElementById('divResponse');

    if(ajax.status != 200)
        divR.style.color = '#FF0000'; //vermelho
    else
        divR.style.color = '#0000FF';//azul

	//escrever na div de resposta
	divResponse.innerHTML = response;
}
