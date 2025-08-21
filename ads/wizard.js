let step = 0;
let formData = { title: '', sourceType: 'file', color: '0ea5e9', gameMode: 'classic', text: '' };

function openWizard(){ step = 0; renderStep(); document.getElementById('wizard').classList.remove('hidden'); }
function closeWizard(){ document.getElementById('wizard').classList.add('hidden'); }
function prevStep(){ if(step>0){ step--; renderStep(); } }
function nextStep(){
	if(step===0){
		const t = document.getElementById('wizTitle').value.trim();
		if(!t){ alert('Please enter a deck name'); return; }
		formData.title=t; formData.sourceType=document.querySelector('input[name="sourceType"]:checked').value; formData.color=document.getElementById('wizColor').value; step=1; renderStep(); return;
	}
	if(step===1){
		if(formData.sourceType==='paste'){ formData.text = document.getElementById('wizText').value; }
		step=2; renderStep(); return;
	}
	if(step===2){ formData.gameMode=document.querySelector('input[name="gameMode"]:checked').value; step=3; renderStep(); return; }
	if(step===3){
		// Create deck with placeholder cards and redirect to edit
		createDeck();
	}
}

function renderStep(){
	const el = document.getElementById('wizStep');
	if(step===0){
		el.innerHTML = `
			<h3>New deck</h3>
			<label>Deck name<input id="wizTitle" type="text" placeholder="e.g., Chapter 1"/></label>
			<fieldset class="choice"><legend>Source</legend>
				<label><input type="radio" name="sourceType" value="file" checked> File upload</label>
				<label><input type="radio" name="sourceType" value="paste"> Paste text</label>
			</fieldset>
			<label>Card color<input id="wizColor" type="text" value="0ea5e9"/></label>
		`;
		return;
	}
	if(step===1){
		el.innerHTML = formData.sourceType==='file' ? `
			<h3>Upload file</h3>
			<div class="panel">Drag & drop here (placeholder) or click to browse.</div>
		` : `
			<h3>Paste text</h3>
			<textarea id="wizText" rows="8" style="width:100%" placeholder="Paste study material here..."></textarea>
		`;
		return;
	}
	if(step===2){
		el.innerHTML = `
			<h3>Choose game mode</h3>
			<label><input type="radio" name="gameMode" value="classic" checked> Classic</label>
			<label><input type="radio" name="gameMode" value="quiz"> Quiz</label>
		`;
		return;
	}
	if(step===3){
		el.innerHTML = `
			<h3>Generating cards…</h3>
			<p class="muted">This is a placeholder; conversion will be integrated later.</p>
		`;
	}
}

async function createDeck(){
	try{
		const res = await fetch('save_deck.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(formData) });
		const data = await res.json();
		if(data && data.did){ window.location.href = 'app.php?route=deck/edit&did='+data.did; return; }
		alert('Failed to create deck');
	}catch(e){ alert('Error creating deck'); }
}


