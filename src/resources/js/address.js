const initCwpAddress = class {

    base_url = '';
    elements = {
        code : null,
        pref : null,
        city: null,
        town: null
    };

    constructor(base_url, codeElement, prefElement, cityElement, townElement) {
        this.base_url = base_url;
        this.elements = {
            code : codeElement,
            pref : prefElement,
            city: cityElement,
            town: townElement
        };

        const t = this;

        let code = t.elements.code.val()
        console.log(code);
        if(code == undefined || code == '' || code.length < 7)
        {
            fetchAddressData( t.base_url, 'prefecture', {}, t.elements)
        }

        t.elements.code.on("focusout", function (){
            let code = $(this).val();
            if(!isNaN(code) && code != undefined && code.length == 7)
            {
                fetchAddressData( t.base_url, 'location_list', {code : code}, t.elements)
            }
        });

        t.elements.pref.on("change", function (){
            let pref = $(this).val();
            if(pref != undefined && pref.length != '')
            {
                fetchAddressData(t.base_url, 'city', {pref : pref}, t.elements);
                t.elements.city.val('');
                t.elements.town.val('');
            }
        });

        t.elements.city.on("change", function (){
            let city = $(this).val();
            if(city != undefined && city.length != '')
            {
                let pref = t.elements.pref.val();
                fetchAddressData(t.base_url,'town', {city : city, pref : pref}, t.elements);
                t.elements.town.val('');
            }
        });

        t.elements.town.on("change", function (){
            let code = $('option:selected', this).attr('code');
            if(code != undefined && code.length == 7)
            {
                t.elements.code.val(code);
            }
        });

        function fetchAddressData(base_url, type, params, elements)
        {
            let url = base_url + '/address_api/jp/';
            if(type == 'location')
                url += params.code + '/location';
            else if(type == 'location_list')
                url += params.code + '/location_list';
            else if(type == 'prefecture')
                url += '/prefectures';
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
                            option += "<option data-id='" + data[i] + "' value='" + data[i] + "'></option>";
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
                    }
                })
                .catch(thrown => {
                    if (axios.isCancel(thrown)) {
                        console.log('Request canceled', thrown.message);
                    } else {
                        console.log(thrown.response);
                    }
                })
                .finally(() => {

                });
        }

    }

};


