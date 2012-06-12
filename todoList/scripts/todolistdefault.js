var listItemCNames = ["todolist-item-1", "todolist-item-2", "todolist-item-3"];

var listItemBldr = new TODOLIST_DEF_HtmlListItemBuilder(listItemCNames);

var nameContId = "lists-container";

var listsOfBldr = new TODOLIST_DEF_HtmlListsOfListsBuilder(nameContId,
        listItemBldr, "listManager.changeMode");

var listBuilder = new TODOLIST_DEF_HtmlListBuilder(nameContId,
        listItemBldr, "listManager.changeMode");

var listManager;

var receiveInfo = function (jsonObj) {
    listManager = new TODOLIST_manager(jsonObj, listsOfBldr, listBuilder);
}
