<section id="main-section">
		
	<div class="FAQ-header">FAQ</div>
		
		
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i create a project?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Log in.</li>
				<li>Click on create project icon at the top of the screen.</li>
				<li>Fill the required input fields, which are project topic, university name, department name and student email.</li>
				<li>Click create.</li>
			</ol>
		</div>
	</div>
	
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i edit a project?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Click on the project.</li>
				<li>Click on edit from the navigation menu.</li>
				<li>Fill the required inputs, which are topic, privacy and description.</li>
				<li>Click save.</li>
			</ol>
			Note: Only a supervisor of a project can edit that project.
		</div>
	</div>
	
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i download a project document?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Click on the project.</li>
				<li>Click on download document.</li>
				<li>The document will be downloaded.</li>
			</ol>
		</div>
	</div>
	
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i upload a project document?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Click on the project.</li>
				<li>Click on documents from the navigation menu.</li>
				<li>On the upload form choose the document to upload.</li>
				<li>Click upload.</li>
			</ol>
			Note: Only a student of a project can upload a document to that project.
		</div>
	</div>

	
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i approve a project document?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Click on the project.</li>
				<li>Click on documents from the navigation menu.</li>
				<li>From the list of documents choose the one to approve.</li>
				<li>Click approve which is the <strong>check icon</strong>.</li>
			</ol>
			Note: Only a supervisor of a project can approve a project's document.
		</div>
	</div>
	
	<div class="FAQ-box">
		<button class="FAQ-button">
			<span>How do i disapprove a project document?</span><i>+</i>
		</button>
		<div class="FAQ-body">
			<ol>
				<li>Click on the project.</li>
				<li>Click on documents from the navigation menu.</li>
				<li>From the list of documents choose the one to approve.</li>
				<li>Click disapprove which is the <strong>times icon</strong>.</li>
			</ol>
			Note: Only a supervisor of a project can disapprove a project's document.
		</div>
	</div>
	
</section>	
	
<script type="text/javascript" src="res/js/Peak.js"></script>

<script type="text/javascript">

var faqBtns = _cl("FAQ-button");
for (var i=0; i<faqBtns.length; i++) {
	faqBtns[i].addEventListener("click", showFaqBody);
}

var faqBodies = _cl("FAQ-body");



function showFaqBody () {
	
	if (this.nextElementSibling.style.height == "0px" || this.nextElementSibling.style.height == "") {
		this.children[1].innerHTML = "-";
		setBodyHeight(this.nextElementSibling, getBodyHeight(this.nextElementSibling), "10px");
		hideBody(this);
	} else {
		this.children[1].innerHTML = "+";
		setBodyHeight(this.nextElementSibling, "0px", "0px");
	}

}

function hideBody (btn) {
	for (var i=0; i<faqBtns.length; i++) {
		if (faqBtns[i] != btn) {
			faqBtns[i].children[1].innerHTML = "+";
			setBodyHeight(faqBodies[i], "0px", "0px");
		}
	}
}

function setBodyHeight (body, h, pad) {
	body.style.height = h;
	body.style.padding = pad;
}

function getBodyHeight (body) {
	var x = 0;
	var div = _ce("div");
	div.innerHTML = body.innerHTML;
	div.className = "FAQ-body-fake";
	document.body.appendChild(div);
	x = div.offsetHeight;
	document.body.removeChild(div);
	return x+"px";
}


hideBody(null);

</script>
