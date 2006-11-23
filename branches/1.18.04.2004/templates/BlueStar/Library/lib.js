// JavaScript Document

// crée par Narfight (narfight@lna.be) pour ClanLite  -  http://clanlite.lna.be

// affiche/cache des calques
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
	try
	{
		if(confirm("Ajouter "+screen+" à votre liste de Contacts ?")==true)
		{
			MsgrObj.AddContact(0,person);
		}
		if(confirm("Envoyer un message instantané à "+screen+" ?")==true)
		{
			MsgrObj.InstantMessage(person);
		}
	}
	catch(e) 
	{
		prompt("Une erreur s'est produite en lancent MsnM!\nvoici sont contact pour le rajouter manuellement", person);
	}
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
	trouve('flash_poper').style.left = x-60 + 'px';
	trouve('flash_poper').style.top = y+20 + 'px';
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
prevId = "";

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

/* pour remplacer la balise marquee */
/* Copyright 2001 : Atout Développement */
/* Auteur : Yvan Vanwynsberghe		      */
var ns4 = (document.layers)? true:false;   			//NS 4 
var ie4 = (document.all)? true:false;   				//IE 4 
var dom = (document.getElementById)? true:false;   //DOM

function GetCSS(MyObject)
	{
  if (dom || ie4) return MyObject.style;
  else if (ns4) return MyObject;
  else return 0;
	}

function GetHeight(MyObject)
	{ 
  if (dom || ie4) return MyObject.offsetHeight;
  else if (ns4) return MyObject.clip.height;
  else return 0;
	}
	
function GetWidth(MyObject)
	{ 
  if (dom || ie4) return MyObject.offsetWidth;
  else if (ns4) return MyObject.clip.width;
  else return 0;
	}

function GetTop(MyObject)
	{ 
  if (dom || ie4) 
  	return (MyObject.offsetTop);
  if (ns4) return MyObject.y;
  	return 0;
	}

function GetLeft(MyObject)
	{ 
  if (dom || ie4) return MyObject.offsetLeft;
  if (ns4) return MyObject.x;
  return 0;
	}

function MoveObject(myX,myY)
	{
  this.X = myX;
  this.Y = myY;
  this.CSS.left=this.X;
  this.CSS.top=this.Y;
  }

function MoveObjectUp(mystep)
	{
  this.Y -= mystep;
  this.CSS.top=this.Y;
  }

function MoveObjectDown(mystep)
	{
  this.Y += mystep;
  this.CSS.top=this.Y;
  }

function CreateObject(DivId,MyObject)
		{
    if (MyObject)
    	this.Object = MyObject;
    else
    	this.Object = trouve(DivId);
    
    if (this.Object)
    	{
      this.CSS = GetCSS(this.Object);
      this.Height = GetHeight(this.Object);
      this.Width = GetWidth(this.Object);
      this.X = GetTop(this.Object);
      this.Y = GetLeft(this.Object);
      this.Move = MoveObject;
      this.Up = MoveObjectUp;
      this.Down = MoveObjectDown;
      }
    return this;
    }

function DelTextNode(MyObject)
	{
  var node = MyObject.firstChild;
  var next;

  while (node)
  	{
    next = node.nextSibling;
    if (node.nodeType == 3)
      MyObject.removeChild(node);
    node = next;
  	}
  }

function CreateChildren(MyObject,HoriSpacer,VertSpacer)
	{
  var i=0;
  var MyChildren = new Array();
  if (dom)
  	{
    DelTextNode(MyObject);
    for (i=0;i<MyObject.childNodes.length;i++)
    	{
    	MyChildren[i] = new CreateObject(0,MyObject.childNodes[i]);
      MyChildren[i].Move(i*HoriSpacer,i*VertSpacer);
      }
    return MyChildren;
    }
  if (ie4)
  	{
    for (i=0;i<MyObject.children.length;i++)
    	{
      MyChildren[i] = new CreateObject(0,MyObject.children(i));
      MyChildren[i].Move(i*HoriSpacer,i*VertSpacer);
      }
    return MyChildren;
    }
  if (ns4)
  	{
    for (i=0;i<MyObject.document.layers.length;i++)
    	{
      MyChildren[i] = new CreateObject(0,MyObject.layers[i]);
      MyChildren[i].Move(i*HoriSpacer,i*VertSpacer);
      }
    return MyChildren;   
    }
  }

function ScrollUp()
	{
  var MyInterval = this.Interval1;
  this.stop();
  if (this.Children[this.FirstChildren].Y<-this.threshold)
  	{
    MyInterval = this.Interval2;
 	  this.Children[this.FirstChildren].Down(this.TotalHeight);
    if (this.FirstChildren<this.Children.length-1)
    	{
    	this.FirstChildren++;
      this.threshold += this.Children[this.FirstChildren].Height;
      }
    else
    	{
    	this.FirstChildren = 0;
      this.threshold = this.Children[this.FirstChildren].Height+this.Spacer;
      }
    }
	for (var i=0;i<this.Children.length;i++)
  	{
    this.Children[i].Up(this.Step);    
    }
  this.ProcessId = setTimeout(this.name + '.start()', MyInterval);
  }

  
function ScrollStop()
	{
  if (this.ProcessId)
    clearTimeout(this.ProcessId);
  this.ProcessId = null;
	}

function Box(BoxName, DivId, myStep, myTempo1, myTempo2, mySpacer)
	{
  this.name     = BoxName;
  this.Step  = myStep ? myStep : 1;
  this.Interval1 = myTempo1 ? myTempo1 : 100;
  this.Interval2 = myTempo2 ? myTempo2 : 100;
  this.Spacer = mySpacer ? mySpacer : 0;
  this.ProcessId	= null;
  this.Container = new CreateObject(DivId);
  this.Children = new CreateChildren(this.Container.Object,0,mySpacer);
  this.FirstChildren = 0;
  this.LastChildren = this.Children.length-1;
  this.threshold = this.Children[0].Height+this.Spacer;
  var myHeight = 0;
  for (var i=0;i<this.Children.length;i++) 
  	{
    myHeight += (this.Children[i].Height + this.Spacer);
    }
  this.TotalHeight = myHeight;
  this.Container.visibility = 'visible';
	}

Box.prototype.start = ScrollUp;
Box.prototype.stop = ScrollStop;
