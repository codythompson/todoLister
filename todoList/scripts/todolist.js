var TODO_listsInfoDivId = "lists-container";
var TODO_listsInfoChildDivClass = "lists-container-listInfo";
var TODO_failure_listsInfoChildDivClass = "lists-container-listInfo-failure";
var TODO_listNameSpanClass = "lists-container-listName";

var TODOLIST = function() {
    this.mode = true;

    this.listsInfo;

    this.listsInfoDivId = TODO_listsInfoDivId;
    this.listsInfoChildDivClass = TODO_listsInfoChildDivClass;
    this.failure_listsInfoChildDivClass = TODO_failure_listsInfoChildDivClass;

    this.setListsInfo = function(jsonObj) {
        this.listsInfo = jsonObj;
    }

    this.setUserMode = function (newMode) {
        //TODO:
        console.log("DEV ERROR: setUserMode not implemented");
    }

    this.createListNameElement = function(listNameObj) {
        var listDiv = document.createElement("div");

        var listNameSpan = document.createElement("span");
        listNameSpan.className = TODO_listNameSpanClass;

        var listNameText = document.createTextNode(listNameObj.name);

        listNameSpan.appendChild(listNameText);
        listDiv.appendChild(listNameSpan);
        return listDiv;
    }

    this.displayListsInfo = function() {
	var parentContainer = document.getElementById(this.listsInfoDivId);
	
        var listsNamesArray = this.listsInfo.data;
        for (var i = 0; i < listsNamesArray.length; i++) {
            var child = document
            var listNameDiv =
                this.createListNameElement(listsNamesArray[i]);
            parentContainer.appendChild(listNameDiv);
        }
    }

    this.displayList = function() {
    }

    this.displayError = function() {
	var parentContainer = document.getElementById(this.listsInfoDivId);
	
        var failChild = document.createElement("div");
        failChild.className = this.failure_listsInfoChildDivClass;
        //TODO display better error message
	var failChildText = document.createTextNode(this.listsInfo.message);
	failChild.appendChild(failChildText);
	parentContainer.appendChild(failChild);
    }

    this.display = function() {
        if (this.listsInfo.response === 1) {
            if (this.mode == true) {
                this.displayListsInfo();
            } else {
                //TODO
            }
        } else {
            this.displayError();
        }
    }

    this.onReady = function() {
        this.display();
    }
}

var TODO_obj = new TODOLIST();

var TODO_onReady = function() {
	TODO_obj.onReady();
}

//
$(document).ready(TODO_onReady);
