function Observable(url, etag, cb, timeout)
{
	this.url = url;
	this.etag = etag;
	this.cb = cb;	
	this.timeout = timeout;
}