var TODOLIST_listInfo = function(listInfo) {
    this.listInfo = listInfo;

    this.setListInfo = function (jsonObj) {
        this.listInfo = jsonObj;
    }

    this.errorOccurred = function() {
        return (this.listInfo.response !== 1);
    }

    this.getResponseCode = function() {
        return this.listInfo.response;
    }

    this.getResponseMessage = function() {
        return this.listInfo.message;
    }

    this.getMode = function () {
        return this.listInfo.mode;
    }

    this.modeIsListsOfLists = function () {
        return (this.listInfo.mode === true);
    }

    this.modeIsList = function () {
        return (typeof this.listInfo.mode === "string" && 
                this.listInfo.mode !== "")
    }

    this.getListData = function () {
        return this.listInfo.data;
    }
}

var TODOLIST_DEF_HtmlListItemBuilder = function (listItemClassNames) {
    this.listItemClassNames = listItemClassNames;

    this.isSpan = true;

    this.getItem = function(index, text) {
        var eleType = "div";
        if (this.isSpan) {
            eleType = "span";
        }
        var itemCont = document.createElement("div");
        var classNameIndex = index % this.listItemClassNames.length;
        itemCont.className = this.listItemClassNames[classNameIndex];

        var item = document.createElement("button");
        var itemText = document.createTextNode(text);

        item.appendChild(itemText);
        itemCont.appendChild(item);

        return itemCont;
    }
}

var TODOLIST_DEF_HtmlListsOfListsBuilder = function (nameContainerId
        /*, iconContainerId*/, listItemBuilder) {

    this.nameContainerId = nameContainerId;
    //this.iconContainerId = iconContainerId;
    
    this.listItemBuilder = listItemBuilder;

    this.buildList = function (listData) {
        var nameCont = document.getElementById(this.nameContainerId);
        //var iconCont = document.getElementById(this.iconContainerId);

        for (var i = 0; i < listData.length; i++) {
            var listEle = this.listItemBuilder.getItem(i, listData[i].name);
            nameCont.appendChild(listEle);
        }
    }
}

var TODOLIST_onReadyFuncs = [];
var TODOLIST_onReady = function() {
    for (var i = 0; i < TODOLIST_onReadyFuncs.length; i++) {
        TODOLIST_onReadyFuncs[i].onReady();
    }
}
$(document).ready(TODOLIST_onReady);

var TODOLIST_manager = function (jsonObj, listsOfListsBuilder/*, listBuilder*/) {
    this.listInfo = new TODOLIST_listInfo(jsonObj);

    this.listsOfBuilder = listsOfListsBuilder;
    //this.listBuilder = listBuilder;

    this.buildHtml = function() {
        if (this.listInfo.errorOccurred()) {
            this.buildErrorHtml();
        } else if (this.listInfo.modeIsListsOfLists()) {
            var listData = this.listInfo.getListData();
            this.listsOfBuilder.buildList(listData);
        }
    }

    this.buildErrorHtml = function() {
        console.log("buildErrorHtml no implemented yet");
    }

    this.onReady = function() {
        this.buildHtml();
    }

    TODOLIST_onReadyFuncs.push(this);
}
