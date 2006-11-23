// JavaScript Document
// crée par Narfight (narfight@clanlite.org) pour ClanLite  -  http://www.clanlite.org
function trouve(id)
{
	if (!document.getElementById)
	{
		return;
	}
    if (document.all)
	{
		return eval('document.all.' + id);
	}
	else
	{
		return document.getElementById(id);
	}
}
function demande(txt)
{
    return (confirm(txt) ? true : false);
}
function toggle_msg(id,champ,condition,obj)
{
	if ( obj == 'checked')
	{
		trouve(id).style.display = (trouve(champ).checked == true ? 'block' : 'none');
		return
	}
	if (condition != '')
	{
		trouve(id).style.display = (trouve(champ).value == condition ? 'block' : 'none');
	}
	else
	{
		trouve(id).style.display = (trouve(id).style.display == 'none' ? 'block' : 'none');
	}
}
// vérification de formulaire
function formverif(id,type,plus)
{
	if (type == 'nbr')
	{
		if (trouve(id).value.length < plus)
		{
			trouve(id).setAttribute('class','champ_movais');
		}
		else
		{
			trouve(id).setAttribute('class','champ_bon');
		}
	}
	if (type == 'comparer')
	{
		if (trouve(id).value != trouve(plus).value)
		{
			trouve(id).setAttribute('class','champ_movais');
		}
		else
		{
			trouve(id).setAttribute('class','champ_bon');
		}
	}
	if (type == 'mail')
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(trouve(id).value))
		{
			trouve(id).setAttribute('class','champ_bon');
		}
		else
		{
			trouve(id).setAttribute('class','champ_movais');
		}
	}
	if (type == 'chiffre')
	{
		if (parseFloat(trouve(id).value))
		{
			if (plus != '')
			{
				if(trouve(id).value <= plus)
				{
					trouve(id).setAttribute('class','champ_bon');
				}
				else
				{
					trouve(id).setAttribute('class','champ_movais');
				}
			}
			else
			{
				trouve(id).setAttribute('class','champ_bon');
			}
		}
		else
		{
			trouve(id).setAttribute('class','champ_movais');
		}
	}
	if (type == 'autre')
	{
		if (trouve(id).value == plus)
		{
			trouve(id).setAttribute('class','champ_movais');
		}
		else
		{
			trouve(id).setAttribute('class','champ_bon');
		}
	}
}
function DoInstantMessage(person,screen)
{
	prompt("voici le Msn-Messenger de " +screen+ ".", person);
}
// pour les smilies
// c'est une fonction de phpBB2 a peux de chose
function emoticon(text, where)
{
	var txtarea = trouve(where);
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos)
	{
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
	}
	else if ( txtarea.selectionStart || txtarea.selectionStart == 0 )
	{
		var before = (txtarea.value).substring(0, txtarea.selectionStart);
		var after  = (txtarea.value).substring(txtarea.selectionEnd, txtarea.textLength);
		txtarea.value = before + text + after;
	}
	else
	{
		txtarea.value  += text;
	}
	txtarea.focus();
}
// pour mes message d'aide
if(navigator.appName.substring(0,3) == "Net")
{
	document.captureEvents(Event.MOUSEMOVE);
}
document.onmousemove = get_mouse;

function get_mouse(e)
{
	var x = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
	var y = (navigator.appName.substring(0,3) == "Net") ? e.pageY : event.y+document.body.scrollTop;
	if (trouve('flash_poper').style.visibility == "visible")
	{
		trouve('flash_poper').style.left = x-60 + 'px';
		trouve('flash_poper').style.top = y+20 + 'px';
	}
}

function poplink(msg)
{
	trouve('flash_poper').innerHTML = msg;
	trouve('flash_poper').style.visibility = "visible";
}

function kill_poplink()
{
  	trouve('flash_poper').innerHTML = '';
	trouve('flash_poper').style.visibility = "hidden";
}
/*
Copyright (c) 2003 Ylab, Utrecht, NL
Author: Yohan Creemers
version 1.1
*/
var loadFunctions = new Array();
function addLoadFunction(f)
{
	loadFunctions[loadFunctions.length] = new Function(f);
}
window.onload   = function() {for (var i=0; i<loadFunctions.length; i++){loadFunctions[i]();}} 

// toegevoegd Joost Tel 20030526
// items niet met nummers maar met letters; A..Z, en submenus AA..AZ, BA..BZ enz.
var prevId;
prevId = '';

function togglej(id)
{
	// alle menuitems sluiten die niet voorlopers zijn van id
	for (i=1;(i<=prevId.length) && (i<=id.length);i++)
	{
		if (id.substring(1,i)!=prevId.substring(1,i))
		{
			el = trouve("toggle_" + prevId.substring(1,i));
			el.style.display = "none";
		}
	}
	for (i=1;i<=id.length;i++)
	{
		el = trouve("toggle_" + id.substring(1,i));
		el.style.display = "block";
	}
	prevId = id
}
// einde toevoeging Joost Tel
var prevEl;
function toggle(id)
{
	if (prevEl){prevEl.style.display = "none"}
	el = trouve("toggle_" + id);
	el.style.display = "block";
	prevEl = el;
	//el.style.display = (el.style.display != "block") ? "block" : "none";
}

function level(id)
{
	el = trouve("level" + id);
	el.style.display = "block";
	prevEl = el;
	//el.style.display = (el.style.display != "block") ? "block" : "none";
}

// from www.pcinpact.com
function bbcode_insert(text1,text2, where) 
{ 
	var ta = trouve(where);
	if (document.selection)
	{ 
		var str = document.selection.createRange().text; 
		ta.focus(); 
		var sel = document.selection.createRange(); 
		if (text2!="") 
		{ 
			if (str=="") 
			{ 
				var instances = countInstances(text1,text2); 
				if (instances%2 != 0)
				{
					sel.text = sel.text + text2;
				} 
				else
				{
					sel.text = sel.text + text1;
				} 
			} 
			else 
			{ 
				sel.text = text1 + sel.text + text2; 
			} 
		} 
		else 
		{ 
			sel.text = sel.text + text1; 
		} 
	} 
	else if (ta.selectionStart || ta.selectionStart == 0) 
	{ 
		if (ta.selectionEnd > ta.value.length)
		{
			ta.selectionEnd = ta.value.length;
		}
		var firstPos = ta.selectionStart; 
		var secondPos = ta.selectionEnd+text1.length;
		var contenuScrollTop = ta.scrollTop;
		
		ta.value=ta.value.slice(0,firstPos)+text1+ta.value.slice(firstPos); 
		ta.value=ta.value.slice(0,secondPos)+text2+ta.value.slice(secondPos); 
				 
		ta.selectionStart = firstPos+text1.length; 
		ta.selectionEnd = secondPos; 
		ta.focus();
		ta.scrollTop = contenuScrollTop;
	} 
	else 
	{ // Opera 
		var sel = document.principal.contenu;    
		var instances = countInstances(text1,text2); 
		if (instances%2 != 0 && text2 != "")
		{
			sel.value = sel.value + text2;
		}
		else
		{
			sel.value = sel.value + text1;
		} 
	}  
} 