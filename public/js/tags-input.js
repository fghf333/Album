/*
var states = [ { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    },
    { "value": 2 , "text": "London"      , "continent": "Europe"    },
    { "value": 3 , "text": "Paris"       , "continent": "Europe"    },
    { "value": 4 , "text": "Washington"  , "continent": "America"   },
    { "value": 5 , "text": "Mexico City" , "continent": "America"   },
    { "value": 6 , "text": "Buenos Aires", "continent": "America"   },
    { "value": 7 , "text": "Sydney"      , "continent": "Australia" },
    { "value": 8 , "text": "Wellington"  , "continent": "Australia" },
    { "value": 9 , "text": "Canberra"    , "continent": "Australia" },
    { "value": 10, "text": "Beijing"     , "continent": "Asia"      },
    { "value": 11, "text": "New Delhi"   , "continent": "Asia"      },
    { "value": 12, "text": "Kathmandu"   , "continent": "Asia"      },
    { "value": 13, "text": "Cairo"       , "continent": "Africa"    },
    { "value": 14, "text": "Cape Town"   , "continent": "Africa"    },
    { "value": 15, "text": "Kinshasa"    , "continent": "Africa"    }
];
*/

    var newvar = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: window.tags
    });

    $('#tags-input').tagsinput({
        itemValue: 'id',
        itemText: 'name',
        typeaheadjs: {
            name: 'states',
            displayKey: 'name',
            source: newvar.ttAdapter()
        }
    });



    var newvar = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: window.tags
    });

    var elt = $('#tags-input-edit');
    elt.tagsinput({
        itemValue: 'id',
        itemText: 'name',
        typeaheadjs: {
            name: 'states',
            displayKey: 'name',
            source: newvar.ttAdapter()
        }
    });
    for (var i=0; i <= window.ImageTags.length-1; i++) {

        elt.tagsinput('add', window.ImageTags[i]);

    }
