function HTMLtoValue(text){
	
	text=text.replace(/&amp;/,'&');
	text=text.replace(/&aacute;/,'á');
	text=text.replace(/&eacute;/,'é');
	text=text.replace(/&iacute;/,'í');
	text=text.replace(/&oacute;/,'ó');
	text=text.replace(/&uacute;/,'ú');
	text=text.replace(/&ntilde;/,'ñ');
	text=text.replace(/<br\/>/gi,'');	
	text=text.replace(/<br>/gi,'');	
	return text;
}

