function Observable(url, etag, cb)
{
	this.url = url;
	this.etag = etag;
	this.cb = cb;	
}