class TrackerHistory {
	static LOCAL_STORAGE_DATA_KEY = "workout-tracker-entries";
	constructor(root) {
		this.root = root;
		this.root.insertAdjacentHTML("afterbegin", TrackerHistory.html());

		this.loadEntries();
		this.updateView();
	}

	static html() {
		return `      
			<table class="history">
				<thead>
					<tr>
					<th>Date</th>
					<th>workout</th>
					<th>Duration</th>
					</tr>
				</thead>
				<tbody class="history_entries"></tbody>
				<tbody>
					<tr class="history_row history_row_add">
					<td colspan ="1">	
						<span class="history_exit" onclick="toggleOverlay('history-div')">Turn off</button>
					</td>
					<td colspan = "3">
					</td>
					</tr>
				</tbody>
			</table>

		  `;
	}

	static rowHtml() {
		return `
			<tr class="history_row">
				<td>
					<span class="history_date"></span>
				</td>
				<td>
					<span class="history_workout"></span>
				</td>
				<td>
					<span class="history_duration"></span>
					<span class="history_text">minutes</span>
				</td>
			</tr>
		`;
	}

	loadEntries() {
		this.entries = JSON.parse(localStorage.getItem(TrackerHistory.LOCAL_STORAGE_DATA_KEY) || "[]");
	}

	updateView() {
		const tableBody = this.root.querySelector(".history_entries");
		const addRow = data => {
			const template = document.createElement("template");
			let row = null;

			template.innerHTML = TrackerHistory.rowHtml().trim();
			row = template.content.firstElementChild;

			row.querySelector(".history_date").innerHTML = data.date;	
			row.querySelector(".history_workout").innerHTML = data.workout;	
			row.querySelector(".history_duration").innerHTML = data.duration;	
			tableBody.appendChild(row);
		};

		this.entries.forEach(data => addRow(data));
	}
}
// Add squares

const squares = document.querySelector('.squares');
for (var i = 1; i < 365; i++) {
  const level = Math.floor(Math.random() * 3);  
  squares.insertAdjacentHTML('beforeend', `<li data-level="${level}"></li>`);
}


const app = document.getElementById("history");

const wt = new TrackerHistory(app);

window.wt = wt;


