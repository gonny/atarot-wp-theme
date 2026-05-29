var _ads = 
{
    apiUrl: 'http://10.1.4.25/%23upravarna/objectTest',
    iframeId: '_ads_if',
	//serviceId: !serviceId ? '' : serviceId,
    adsCount: 0,
    //this.itemsToDeploy, slouží pro účely testování, nebo zobrazení reklamy ne na cílovém serveru když je dělá se v loadData
    //activeAds: {}, //aktivnich kontejneru do kterych se bude davat reklama
    //freeAds: [], //volne reklamni plochy
    tagName: 'div',
    loaded: false,
    matchedElements: [], //elementy, ktere se premeni na reklamni plochy
    jmElements: {},
    browserFuncionality: !!document.getElementsByClassName,
    elementRegexp: function(item)
    {
        this.browserFuncionality ? false : new RegExp('(^|\\s)'+item+'(\\s|$)');
    },
    /**
    * Zkontroluje zda existuje skript, ktery načítá _ads.jsonDeploy (obsahuje informace o reklame)
    * pokud ne, pak jej načte v ostatním případě vloží do vybraného ID reklamu z informací získaných načtením skriptu
    * z předchozího kroku
    * 
    * @var elementId = je ID v celém tvaru (bsap_1234732)
    * @var zoneId = je jen ID reklamní zóny (1234732)
    * Ještě zde bylo userKey tzn klíč, kterým se indikuje na serveru soubor s reklamou který se má načíst
    * tento key jsem dal to this.serviceId, ale je možné že je užitečné těchto klíčů mít více?
    */
    loadData : function(elementId, zoneId)
    {
        this.matchedElements[zoneId] = this.matchedElements[zoneId] || [];
        this.matchedElements[zoneId].push(elementId);
        if(!document.getElementById('_ads_js'+this.serviceId))
        {
            var script = document.createElement('script'),
                time = new Date();
            
            time.setMinutes(0);
            time.setSeconds(0);
            time.setMilliseconds(0);
             
            script.type = 'text/javascript';
            script.id = '_ads_js'+ this.serviceId;
            script.src = this.apiUrl + '/s_'+this.serviceId+'.php?w='+time.getTime();
            script.setAttribute('async', 'async');
            (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(script);
        }
        else if(this.itemsToDeploy)
        {
            this.deploy(this.itemsToDeploy);
        }
    },
    exec: function()
    {
        if(!this.loaded)
        {
            this.loaded = true;
            elements = this.getMatchedElements('aadignite'),
                elementRegexp = /aad_([a-f0-9]+)/i;
            for(i in elements)
            {
                elementId = elements[i].getAttribute('id');
                zoneId = elementId.split('_')[1];
                /*primaryKey = elements[i].getAttribute('rel') || elementRegexp.exec(elements[i].className);
                primaryKey = primaryKey[1] ? primaryKey[1] : '';
                alert(primaryKey);*/
                elements[i].className='aad_'+zoneId +' aad';
                this.loadData(elementId, zoneId);
                //this.filter.apply('a','b');
            }
        }
    },
    getMatchedElements : function(item)
    {
        var result = [],
            elements = this.browserFuncionality ?
                document.getElementsByClassName(item) :
                document.getElementsByTagName(this.tagName),
            matchedElements = this.elementRegexp(item);
        for(i = 0; i < elements.length; i++)
        {
            if(!matchedElements || matchedElements.test(elements[i].className))
            {
                result.push(elements[i]);
                this.jmElements[i] = elements[i];
            }
        }
        return result;
    },
    proceedData: function(data)
    {
        //this.jsonZones = this.jsonZones === 'object' ? this.jsonZones.concat(data.zones) : data.zones;
        this.jsonZones = data.zones;
        this.deploy(data.zones);
    },
    deploy: function (zones)
    {
        for(i in zones)
        {
            element = (this.matchedElements[zones[i].id]) ?
                document.getElementById(this.matchedElements[zones[i].id].pop()) : 
                false;
            if(element)
            {
                new this.deployZone(element, zones[i], this);
            }
        }
    },
    deployZone:  function (targetElement, zoneData, obj)
    {
        var filters = ['all', 'proceeded'];
        var zoneObjects = [],
            zoneFilters = zoneData.filters;
        /**
        * Tady to bude trochu jinak, totiž každá reklama může být filtrována (tzn. zobrazena při splnění konkrétní kondice)
        * Ale je problém, když splňuje více kondic naráz, např. geo = CZ && os = WIN
        * Proto je nutné následující funkci předělat až se dostanu k těm kondicím 
        */
        for(var i = 0; i < filters.length; i++)
        {
           zoneObjects = zoneObjects.concat(typeof zoneFilters[filters[i].toLowerCase()] == 'object' ?
                /**
                * timto ziskam jenom reklamy, ktere jsou validni podle filterBy,
                * tzn. vsechny reklamy jen do jednoho objektu
                */
                zoneFilters[filters[i].toLowerCase()].ads :
                []);
        }
        zoneObjects = !zoneObjects.length ? (zoneFilters.all || zoneData) : {"ads": zoneObjects};
        var activeAds = (!zoneObjects || !zoneObjects.ads || !zoneObjects.ads.length) ?
            [] : obj.getAds(zoneObjects, zoneData.nads),
            activeAd = activeAds[0],
            activeIds = '',
            css = '.bsa_padint{position:relative;font-family:helvetica,arial,verdana,sans-serif;font-size:12px}.bsa_padint ul.bsa_ads{list-style-type:none;margin:0;padding:0}.bsa_padint ul.bsa_ads li{position:relative;margin:0;padding:0}.bsa_padint ul.bsa_ads li.bsa_0{margin:7px 0 2px}.bsa_padint ul.bsa_ads li.bsa_1{margin:0 0 2px}.bsa_padint ul.bsa_ads li.bsa_2{margin:0}.bsa_padint ul.bsa_ads em.bi{position:relative;margin:0}.bsa_padint ul.bsa_ads em.bi img{border:0}.bsa_padint ul.bsa_ads em.bt{font-weight:700;font-size:14px;text-decoration:underline;color:#06c}.bsa_padint ul.bsa_ads em.bu{color:green}.bsa_padint ul.bsa_ads li.bsa_idt{height:3px;border-bottom:1px solid #f1f1f1;font-size:10px;color:#999;margin:0;padding:0}.bsa_padint ul.bsa_ads li.bsa_idt .bsa_idl{background:#fff;position:absolute;top:0;line-height:7px;left:3px;padding:0 3px}.bsa_padint ul.bsa_ads .bsa_idt a{color:#999;height:3px;margin:0;padding:0}.bsa_padint ul.bsa_ads .bsa_idt a:hover{color:#06c;background:none}div.bsa_idb{border-top:1px solid #f1f1f1;font-size:10px;color:#999;position:absolute;bottom:0;left:0;width:100%;height:5px;margin:0;padding:0}div.bsa_idb .bsa_idl{background:#fff;line-height:7px;position:absolute;bottom:2px;right:5px;padding:0 3px}div.bsa_idb a{color:#999;height:3px;text-decoration:none;margin:0;padding:0}div.bsa_idb a em{font-style:normal}div.bsa_idb a:hover{color:#666;background:none}div.bsa_idb a:hover em{font-style:italic}ul.bsa_ads li *{cursor:pointer;}.bsapvariable{width:auto;height:atuo;overflow:hidden;visibility:visible;}.bsapvariable ul.bsa_ads li{padding:5px;width:250px;float:left;text-align:left;}div.bsapvariable ul.bsa_ads li a,div.bsapvariable div.bsa_idb span.bsa_idl,div.bsapvariable div.bsa_idb{text-decoration:none;clear:both;position:relative;width:250px;height:auto;margin:0;}.bsa_padint ul.bsa_ads em{font-style:normal;display:block}div.bsapvariable .bsa_padint ul.bsa_ads em.bd{text-decoration:none;color:black;}div.bsapvariable div.bsa_idb a{display:block;width:250px;text-align:right;height:13px;}.bsa_padint ul.bsa_ads a:hover,.bsa_padint ul.bsa_ads a:hover div.bwr{background-color:#f7f7f7}';
        if(zoneData.type <= 1)
        {
            //pokud nejsou plně obsazena všechna místa, pak je zoneData.showadhere > 0
            var adHereBanner = (typeof (ShowAdHereBanner) === 'object' ?
                    ShowAdHereBanner[zoneData.id] :
                    zoneData.showadhere) > 0,
                repeatBanner = (typeof(RepeatAll) === 'object' ? RepeatAll[zoneData.id] : zoneData.repeathere ) > 0,
                testAd = (typeof(ShowTestAd) === 'object'? ShowTestAd[zoneData.id] : zoneData.showtestads);
            
        }
        if(zoneData.type == 0)
        {
            if(typeof(ShowAdHereBanner) === 'undefined')
            {
                var bannerStyle = zoneData.bannerstyles,
                    width = zoneData.width,
                    height = zoneData.height,
                    normWidth = zoneData.width - 2,
                    normHeight = zoneData.height - 2,
                    vertical = zoneData.vertical > 0 ? zoneData.width + 'px' : '100%',
                    output = '',
                    css = document.createElement('style');
                
                output += 'div.aad_'+zoneData.id+'{width:'+vertical+';display:block;}div.aad_'+zoneData.id+' a{width:'+width+'px;}div.aad_'+zoneData.id+' a img{padding:0;}div.aad_'+zoneData.id+' a em{font-style:normal;}';
                for(i=0; i < bannerStyle.length;i++)
                {
                    output += 'div.aad_'+zoneData.id+' '+bannerStyle[i];
                }
                if( width < 100)
                    output += 'div.aad_'+zoneData.id+' a em{display:block;text-indent:-9000px;}div.aad_'+zoneData.id+' a{height:'+height+';line-height:0;}div.aad_'+zoneData.id+' a.adhere{font-size:0;}';
                    output+='div.aad_'+zoneData.id+' a.adhere{width:'+width+'px;height:'+height+'px;line-height:'+height*8+'%;}html>body div.aad_'+zoneData.id+' a.adhere{width:'+normWidth+'px;height:'+normHeight+'px;}div.aad_'+zoneData.id+' img.s{height:0;width:0;}';
                if(document.getElementById('_ads_css'+obj.serviceId))
                {
                    document.getElementById('_ads_css'+obj.serviceId).innerHTML += output;
                }
                else
                {
                    css.type = 'text/css';
                    css.id = '_ads_css'+obj.serviceId;
                    css.styleSheet ? 
                        (css.styleSheet.cssText = bannerCss) : 
                        css.appendChild( document.createTextNode(output));
                    document.getElementsByTagName('head')[0].appendChild(css);
                }
            }
            output = '';
            for(i in activeAds)
            {
                ad = obj.getAds(activeAds[i],1)[0];
                output += '<a href="'+ad.link+'" class="ad'+i+' '+(i%2===0?'even':'odd')+'" onclick="_ads.fire(\'click\','+ad.id+', '+zoneData.id+')" title="'+ad.alt+'" id="bsa_'+ad.id+'" target="_blank"><img src="'+ad.img+'" width="'+zoneData.width+'" height="'+zoneData.height+'" alt="'+ad.alt+'"/></a>',
                
                activeIds+=ad.id+';'
            }
            j = i;
            for (i = 0; activeAds.length < zoneData.nads && adHereBanner &&
                i < ( repeatBanner ? (zoneData.nads - activeAds.length) : 1); i++, j++ )
            {
                output += '<a href="http://buysellads.com/buy/detail/'+zoneData.siteid+'" title="Advertise Here" class="adhere ad'+j+' '+(j%2===0?'even':'odd')+'" target="_blank">Advertise Here</a>';
            }
        }
        else if (zoneData.type == 1)
        {
            for(i in testAd)
            {
                activeAds.concat({
                    id: -i,
                    link:'http://buysellads.com',
                    title:'BuySellAds.com Online Advertising',
                    text:'Join over 1,000 high quality advertisers who advertise across 750 successful websites, and take control of your ad space!'
                });
                output += '<style type="text/css">'+css+'</style>';
                output +='<div class="aad_unit bsapvariable"><div class="bsa_padint"><ul class="bsa_ads">';
            }
            for(i in activeAds)
            {
                ad = obj.getAds(activeAds[i],1)[0];
                output +=' <li class="bsapt_'+ad.id+' ad'+i+' '+(i%2===0?'even':'odd')+'">'+'<a href="'+ad.link+'" onclick="window.parent._ads.ignite(\'click\','+ad.id+','+zoneData.id+')" target="_blank">'+'<div class="bwr"><em class="bt">'+ad.title+'</em>'+'<em class="bd">'+ad.text+'</em></div></a></li>';
                activeIds += ad.id+';';
            }
            output += "</ul>";
            if( activeAds.length > 0)
                output += '<div class="bsa_idb"><span class="bsa_idl"><a href="http:\/\/buysellads.com\/buy\/detail\/'+zoneData.siteid+'" target="_blank">ads by <em>BSA</em></a></span></div></div></div>';
        }
        else
        {
            alert(activeAd.type);
            if(activeAd.type === 'img')
            {
                alert('img');
            }
        }
        targetElement.innerHTML = output;
        obj.ignite('impression', activeIds, zoneData.id);
       // alert(activeAds.toSource());
        
    },
    ignite : function(type, activeIds, zoneId)
    {
        var u = this.generateCookie('bsau',30),
            s = this.generateCookie('bsas',1/2),
            img = new Image();
        img.src='http://test.atarot.cz/'+type+'.php?z='+zoneId+'&b='+activeIds+'&g='+u+'&s='+s+'&sw='+screen.width+'&sh='+screen.height+'&br='+this.getBrowser()+'&r='+Math.random();
    },
    getBrowser: function()
    {
            var a=navigator.userAgent,
                p=navigator.platform,
                m=function(r,h)
                {
                    for(var i=0;i<h.length;i++)
                        r=r.replace(h[i][0],h[i][1]);
                    return r
                },
                i=(a.match(/Opera|Navigator|Minefield|KHTML|Chrome/) 
                    ? m(a,[[/(Firefox|MSIE|KHTML,\slike\sGecko|Konqueror)/,''],['Chrome Safari','Chrome'],['Minefield','Firefox']])
                    :a).toLowerCase();
                    return[(/(camino|chrome|firefox|opera|msie|safari)/.exec(i)||['','?'])[1],parseFloat((/(camino|chrome|firefox|opera|msie|safari)(\/|\s)([a-z0-9\.\+]*?)(\;|dev|rel|\s|$)/.exec(i)||[0,0,0,0])[3],10)||0,(/(win|mac|linux|iphone|blackberry|pike)/.exec(p.toLowerCase())||['?'])[0]]
        },
    generateCookie : function(what, elapsedTime)
    {
        var c=document.cookie,
            i=c.indexOf(what+'=');
        if( i >= 0)
            return c.substring(i+what.length+1).split(';')[0];
        else
        {
            var d=new Date(),
                nd = +d;
                d.setTime(elapsedTime*3600000+nd);
            document.cookie=what+'='+(nd+Math.random().toString().substr(2,7))+'; expires='+d.toGMTString()+'; path=/';
            return-1;
        }
    },
    getAds : function(zoneObject, adsNumber)
    {
        var adsObjects = zoneObject.ads,
            tDiff = 0,
            result = [],
            chosenAd = [],
            percentage = [],
            b = '';
        
        if(!adsObjects)
        {
            //alert('žádná reklama není přiřazená této stránce');
            return [zoneObject];
        }
        if(adsObjects.length <= adsNumber || adsObjects.length == 1)
        {
            return this.shuffle(adsObjects);
        }
        
        for(i in adsObjects)
        {
            adsObjects[i].remaining = adsObjects[i].cap - adsObjects[i].current;
            tDiff += adsObjects[i].remaining;
        }
        for(i = 0; i < adsObjects.length; i++)
        {
            perc = new Array(((adsObjects[i].remaining / tDiff * 100)|0)+1);
            percentage[i] = [];
            percentage[i].number = perc.length-1;
            percentage[i].start = percentage[i-1] ? (percentage[i-1].start + percentage[i-1].number) : 0;
            b += perc.join(i+',');
        }
        delete perc;
        b = b.substr(0,b.length-1).split(',');
        i = 0;
        if(adsNumber == 1)
            return [adsObjects[b[Math.floor(Math.random()*b.length)]]];
        while(result.length < adsNumber && (v = b[Math.floor(Math.random()*b.length)], chosen = adsObjects[v]))
        {
            //alert(percentage[v]);
            if(!chosenAd[chosen.id])
            {
                result.push(chosen);
                chosenAd[chosen.id] = true;
                b.splice(percentage[v].start, percentage[v].number );
                for(j = parseInt(v)+1; j < percentage.length; j++)
                {
                    percentage[j].start -= percentage[j-1].number;
                }
            }
        }
        delete percentage;
        return result;
        
    },
    shuffle : function (o)
    {
        for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    },
    filter : {
        got : 0,
        cookie : document.cookie,
        //index : cookie.indexOf('country='),
        select : ['all'],
        IAm : function()
        {
            
        },
        apply : function(fs, fn)
        {
            alert('filter');
        }
    }
};

/*oldonload=window.onload;
var loaded = false;
window.onload= function()
{
    _ads.exec();
    if(oldonload)
    {
        oldonload();
    }
};
if(!_ads.loaded)
    _ads.exec();
    
_ads.admin = {
    form : document.testF,
    show : function()
    {
        var repeatAll = this.form.rpt_all.checked ? true : false,
            url = this.form.ad_url,
            position = this.form.position;
        alert(position.selectedIndex);
        alert(position[position.selectedIndex].value);
    }
}*/