const cwpJpAddress = class {

    constructor(config) {
        this.base_url = config.base_url;
        this.elements = config.elements;
        this.loading_text = config.loading_text ?? '読み込み中。。';
        this.tmp_text = '';
        const t = this;

        t.elements.code.on("focusout", function (){
            let code = $(this).val();
            if(!isNaN(code) && code != undefined && code.length == 7)
            {
                t.#fetchAddressData( t.base_url, 'location_list', {code : code}, t.elements)
            }
        });

        t.elements.pref.on("change", function (){
            let pref = $(this).val();
            if(pref != undefined && pref.length != '')
            {
                t.tmp_text = t.elements.city.find('option').eq(0).text();
                t.elements.city.html(t.elements.city.find('option')[0].outerHTML);
                t.elements.city.find('option').eq(0).text(t.loading_text);
                t.elements.town.html(t.elements.town.find('option')[0].outerHTML);

                t.#fetchAddressData(t.base_url, 'city', {pref : pref}, t.elements);
            }
        });

        t.elements.city.on("change", function (){
            let city = $(this).val();
            if(city != undefined && city.length != '')
            {
                t.elements.town.val('');
                t.tmp_text = t.elements.town.find('option').eq(0).text();

                t.elements.town.html(t.elements.town.find('option')[0].outerHTML);
                t.elements.town.find('option').eq(0).text(t.loading_text);

                let pref = t.elements.pref.val();
                t.#fetchAddressData(t.base_url,'town', {city : city, pref : pref}, t.elements);
            }
        });

        t.elements.town.on("change", function (){
            let code = $('option:selected', this).attr('code');
            if(code != undefined && code.length == 7)
            {
                t.elements.code.val(code);
            }
        });

        t.refresh();
    }

    refresh(pref = '', city = '', town = '')
    {
        const t = this;
        pref = pref ? pref : t.elements.pref.attr('old-data');
        city = city ? city : t.elements.city.attr('old-data');
        town = town ? town : t.elements.town.attr('old-data');
        pref = pref == undefined ? '' : pref;
        city = city == undefined ? '' : city;
        town = town == undefined ? '' : town;
        t.#fetchAddressData( t.base_url, 'location_list', {pref : pref, city : city, town : town}, t.elements);
    }

    refreshByCode(code)
    {
        const t = this;
        t.#fetchAddressData( t.base_url, 'location_list', {code : code}, t.elements);
    }

    #fetchAddressData(base_url, type, params, elements)
    {
        const t = this;

        let url = base_url + '/address_api/jp/';
        if(type == 'location')
            url += params.code + '/location';
        else if(type == 'location_list')
        {
            if(params.code)
                url += 'location_list?code=' + params.code;
            else
                url += 'location_list?pref='+ params.pref +'&city=' + params.city;
        }
        else if(type == 'prefecture')
            url += 'prefectures';
        else if(type == 'city')
            url += params.pref + '/cities';
        else if(type == 'town')
            url += params.pref + '/' + params.city + '/towns';

        axios.get(url)
            .then((response) => {
                let data = response.data;
                let prefectures;
                let cities;
                let towns;
                let option;
                if(type == 'location')
                {
                    elements.pref.val(data.pref);
                    elements.city.val(data.city);
                    elements.town.val(data.town);
                }
                else if(type == 'location_list')
                {
                    prefectures = data.list.prefectures;
                    cities = data.list.cities;
                    towns = data.list.towns;

                    option = elements.pref.find('option')[0].outerHTML;
                    for(let i = 0; i < prefectures.length; i++)
                    {
                        option += "<option value='" + prefectures[i] + "'>" + prefectures[i] + "</option>";
                    }
                    elements.pref.html(option);

                    option = elements.city.find('option')[0].outerHTML;
                    for(let i = 0; i < cities.length; i++)
                    {
                        option += "<option value='" + cities[i] + "'>" + cities[i] + "</option>";
                    }
                    elements.city.html(option);

                    option = elements.town.find('option')[0].outerHTML;
                    let town_keys = Object.keys(towns);
                    let key = '';
                    for(let i = 0; i <  town_keys.length; i++)
                    {
                        key  = town_keys[i];
                        option += "<option code='" + key + "' value='" + towns[key] + "'>" + towns[key] + "</option>";
                    }
                    elements.town.html(option);
                    elements.pref.val(data.location.pref);
                    elements.city.val(data.location.city);
                    elements.town.val(data.location.town);
                }
                else if(type == 'prefecture')
                {
                    option = elements.pref.find('option')[0].outerHTML;
                    for(let i = 0; i < data.length; i++)
                    {
                        option += "<option value='" + data[i] + "'>" + data[i] + "</option>";
                    }
                    elements.pref.html(option);
                }
                else if(type == 'city')
                {
                    option = elements.city.find('option')[0].outerHTML;
                    for(let i = 0; i < data.length; i++)
                    {
                        option += "<option value='" + data[i] + "'>" + data[i] + "</option>";
                    }
                    elements.city.html(option);
                    t.elements.city.find('option').eq(0).text(t.tmp_text);
                }
                else if(type == 'town')
                {
                    option = elements.town.find('option')[0].outerHTML;
                    let town_keys = Object.keys(data);
                    let key = '';
                    for(let i = 0; i <  town_keys.length; i++)
                    {
                        key  = town_keys[i];
                        option += "<option code='" + key + "' value='" + data[key] + "'>"+ data[key] +"</option>";
                    }
                    elements.town.html(option);
                    t.elements.town.find('option').eq(0).text(t.tmp_text);
                }
            })
            .catch(thrown => {
                console.log(thrown);
            })
            .finally(() => {

            });
    }

};

const cwpBdAddress = class {

    constructor(config) {
        this.base_url = config.base_url;
        this.elements = config.elements;
        this.loading_text = config.loading_text ?? 'Loading..';
        this.tmp_text = '';
        const t = this;
    }

    //Pending for future update
};


