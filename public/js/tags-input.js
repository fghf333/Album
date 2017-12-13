var newvar = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: window.tags
});

var tag = $('#tags-input');
tag.tagsinput({
    typeaheadjs: {
        name: 'states',
        displayKey: 'name',
        valueKey: 'name',
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


