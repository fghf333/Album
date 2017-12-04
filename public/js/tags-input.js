var newvar = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    // `states` is an array of state names defined in "The Basics"
    local: window.tags
});

var tag = $('#tags-input');
tag.tagsinput({
    confirmKeys: [13, 188],
    itemValue: 'id',
    itemText: 'name',
    typeaheadjs: {
        name: 'states',
        displayKey: 'name',
        source: newvar.ttAdapter()
    }
});


var exists = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: window.tags
});


var elt = $('#tags-input-edit');
elt.tagsinput({
    typeaheadjs: {
        name: 'states',
        displayKey: 'name',
        valueKey: 'name',
        source: exists.ttAdapter()
    }
});


