
const API_URL = "https://wger.de/api/v2/exercise/?language=2";

const searchForm = document.getElementById('search-form');
const selectedExercise = document.getElementById('selected-exrcise ');

searchForm.addEventListener('input', (event) => {
event.preventDefault();
const searchInput = document.getElementById('search-input').value;
	searchWorkout(searchInput);
});

// Use fetch to call the API and get the response as JSON
function searchWorkout(searchInput){
	fetch(API_URL)
		.then(response => response.json())
		.then(data => {
		// Filter the results based on the search input
		const filteredResults = data.results.filter(result =>
			result.name.toLowerCase().includes(searchInput.toLowerCase())
		);
		
		// Display the filtered results on the page
		const resultsContainer = document.getElementById("workouts-table");
		resultsContainer.innerHTML = "";
		
		filteredResults.forEach(result => {
			const name = result.name;

			const workoutDiv = document.createElement("div");
			workoutDiv.innerHTML = `<h2>${name}</h2>`;
			console.log(data);
			resultsContainer.appendChild(workoutDiv);

			workoutDiv.addEventListener('click', () => {
				addExerciseToList(result);
			});
		});
		})
		.catch(error => {
		console.error("Error fetching data: ", error);
		});
}

function addExerciseToList(exercise) {
	console.log(exercise);	
	console.log(exercise.name);

	// create a new row for the table
	const row = document.createElement("tr");

	// create table cells for each property
	const nameCell = document.createElement("td");
	nameCell.textContent = exercise.name;
	row.appendChild(nameCell);
	// append the row to the table body
	selectedExercise.appendChild(row);

}

/*
const searchInput = document.getElementById("searchInput");
const searchResultsTable = document.getElementById("searchResults").querySelector("tbody");
const selectedWorkoutsTable = document.getElementById("selectedWorkouts").querySelector("tbody");

// Search for workouts on input change
searchInput.addEventListener("input", searchWorkouts);

searchForm.addEventListener('input', (event) => {
event.preventDefault();
const searchInput = document.getElementById('search-input').value;
	searchWorkout(searchInput);
});


// Handle clicks on search results table
searchResultsTable.addEventListener("click", addWorkout);

// Search for workouts and display them in the search results table
function searchWorkouts() {
	const searchTerm = searchInput.value;
	fetch(`https://wger.de/api/v2/exercise/search/?term=${searchTerm}`)
		.then(response => response.json())
		.then(data => {
		// Clear search results table
		searchResultsTable.innerHTML = "";
			console.log(data);
		// Add each search result to the table
		data.results.forEach(result => {
			const row = document.createElement("tr");
			row.innerHTML = `<td>${result.name}</td>
							<td>${result.category.name}</td>
							<td>${result.description}</td>`;
			searchResultsTable.appendChild(row);
		});
		})
		.catch(error => console.error(error));
}

// Add a workout to the selected workouts table on click
function addWorkout(event) {
	const clickedRow = event.target.closest("tr");
	if (!clickedRow || clickedRow.parentElement !== searchResultsTable) {
		return;
	}

	const name = clickedRow.cells[0].textContent;
	const category = clickedRow.cells[1].textContent;
	const description = clickedRow.cells[2].textContent;

	// Create a new row in the selected workouts table
	const newRow = selectedWorkoutsTable.insertRow();
	newRow.innerHTML = `<td>${name}</td>
						<td>${category}</td>
						<td>${description}</td>
						<td><input type="number" value="30" min="0" step="5"></td>
						<td><input type="number" value="0" min="0" step="2.5"></td>`;
}*/