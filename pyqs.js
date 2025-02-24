const qnbData = {
    branches: [
      { id: 1, name: "MCA" },
      { id: 2, name: "BCA" },
      { id: 3, name: "MBA" },
      { id: 4, name: "Engineering" },
      { id: 5, name: "MTech" },
      { id: 6, name: "BBA" },
      { id: 7, name: "BSc Nursing" },
      { id: 8, name: "BSc Agriculture" },
    ],
    semesters: {
      MCA: {
        1: ["Mathematics", "Programming", "Data Structures"],
        2: ["Database Systems", "Operating Systems"],
        3: ["COA", "Programming"],
        4: ["RDBMS", "ETC"],
      },
      BCA: {
        1: ["BMC", "C Programming", "ETC", "EVS"],
        2: ["DBMS", "Data Structure", "COA", "AMC"],
        3: ["OOPS", "Operating System", "CG", "MAC"],
        4: ["Python", "IWT", "Cmp. Network", "Software Eng."],
        5: ["Cloud Computing", "AI", "Unix"],
        6: ["PHP", "Ethics & Values"],
      },
      MBA: {
        1: ["Management", "Economics"],
        2: ["Finance", "Marketing"],
        3: ["Management", "Economics"],
        4: ["Finance", "Marketing"],
      },
      BBA: {
        1: ["MAC", "BUSS. MANAGEMENT"],
        2: ["XYZ", "MNO"],
      },
      'BSc Nursing': {
        1: ["Physics", "Eng. Mathematics"],
        2: ["Thermodynamics", "Circuits"],
        3: ["Physics", "Eng. Mathematics"],
        4: ["Thermodynamics", "Circuits"],
        5: ["MAC", "BUSS. MANAGEMENT"],
        6: ["XYZ", "MNO"],
        7: ["COA", "Programming"],
        8: ["RDBMS", "ETC"],

      },
      Engineering: {
        1: ["Physics", "Eng. Mathematics"],
        2: ["Thermodynamics", "Circuits"],
      },
    },

    questions: {
      Mathematics: ["math_q1.pdf", "math_q2.pdf"],
      Programming: ["programming_q1.pdf", "programming_q2.pdf"],
      'Data Structures': ["ds_q1.pdf", "ds_q2.pdf"],
    },
  };

  let currentBranch = "";
  let currentSemester = "";

  // Show branches
  function loadBranches() {
    const branchContainer = document.getElementById("branchContainer");
    branchContainer.innerHTML = qnbData.branches
      .map(
        (branch) => `
        <div class="col-md-3 col-sm-6 branch" data-name="${branch.name}">
          <div class="box" onclick="showSemesters('${branch.name}')">
            <h3>${branch.name}</h3>
          </div>
        </div>
      `
      )
      .join("");
  }

  // Filter branches
  function filterBranches() {
    const searchValue = document.getElementById("searchBar").value.toLowerCase();
    const branches = document.querySelectorAll(".branch");
    branches.forEach((branch) => {
      const branchName = branch.getAttribute("data-name").toLowerCase();
      if (branchName.includes(searchValue)) {
        branch.style.display = "block";
      } else {
        branch.style.display = "none";
      }
    });
  }

  // Show semesters
  function showSemesters(branchName) {
    currentBranch = branchName;
    const semesters = qnbData.semesters[branchName];
    const semesterContainer = document.getElementById("semesterContainer");

    // Update navbar with selected branch
    document.getElementById("navbarBranchName").innerText = `PaperFinder - ${branchName}`;

    document.getElementById("branchTitle").innerText = `${branchName} - Semesters`;
    semesterContainer.innerHTML = Object.keys(semesters || {})
      .map(
        (sem) => `
        <div class="col-md-3 col-sm-6">
          <div class="box" onclick="showSubjects('${branchName}', ${sem})">
            <h3>Semester ${sem}</h3>
          </div>
        </div>
      `
      )
      .join("");

    showSection("semesters");
  }

  // Show subjects
  function showSubjects(branchName, semesterId) {
    currentSemester = semesterId;
    const subjects = qnbData.semesters[branchName][semesterId] || [];
    const subjectContainer = document.getElementById("subjectContainer");

    document.getElementById("semesterTitle").innerText = `${branchName} - Semester ${semesterId} Subjects`;
    subjectContainer.innerHTML = subjects
      .map(
        (subject) => `
        <div class="col-md-3 col-sm-6">
          <div class="box" onclick="showQuestions('${subject}')">
            <h3>${subject}</h3>
          </div>
        </div>
      `
      )
      .join("");

    showSection("subjects");
  }

  // Show questions with download button
  function showQuestions(subjectName) {
    const questions = qnbData.questions[subjectName] || [];
    const questionList = document.getElementById("questionList");

    document.getElementById("subjectTitle").innerText = `${subjectName} - Questions`;
    questionList.innerHTML = questions
      .map(
        (question) => `
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="assets/pdf/${question}" target="_blank">${question}</a>
        <button class="d-btn btn btn-success btn-sm ms-2" onclick="downloadFile('${question}')">Download</button>
      </li>`
      )
      .join("");

    showSection("questions");
  }

  // Download PDF function
  function downloadFile(fileName) {
    const link = document.createElement('a');
    link.href = `assets/pdf/${fileName}`;
    link.download = fileName;  // This will trigger the download
    link.click();
  }

  // Show specific section
  function showSection(sectionId) {
    const sections = document.querySelectorAll("section");
    sections.forEach((section) => section.classList.add("d-none"));

    document.getElementById(sectionId).classList.remove("d-none");
  }

  // Show branches page
  function showBranches() {
    showSection("home");
  }

  // Initialize application
  document.addEventListener("DOMContentLoaded", () => {
    loadBranches();
  });