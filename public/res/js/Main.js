

var searchShowBtn = _id("search-show-btn");
if (searchShowBtn) {
	searchShowBtn.addEventListener("click", showSearchInput);
}

var searchHideBtn = _id("search-hide-btn");
if (searchHideBtn) {
	searchHideBtn.addEventListener("click", hideSearchInput);
}

var searchForm = _id("search-form");

var searchFormBlur = _id("search-form-blur");


function showSearchInput (e) {
	
	e.preventDefault();
	
	searchForm.classList.add("show-search-form");
	searchFormBlur.classList.add("show-search-form");
}


function hideSearchInput () {
	searchForm.classList.remove("show-search-form");
	searchFormBlur.classList.remove("show-search-form");
}






