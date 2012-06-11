var listItemCNames = ["todolist-item-1", "todolist-item-2", "todolist-item-3"];

var listItemBldr = new TODOLIST_DEF_HtmlListItemBuilder(listItemCNames);

var nameContId = "lists-container";

var listsOfBldr = new TODOLIST_DEF_HtmlListsOfListsBuilder(nameContId,
        listItemBldr);

var receiveInfo = function (jsonObj) {
    new TODOLIST_manager(jsonObj, listsOfBldr);
}
