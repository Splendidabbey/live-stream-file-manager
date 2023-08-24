  const video = document.getElementById("livestream-video");
  const playButton = document.getElementById("play-button");
  const joinButton = document.getElementById("join-button");
  // const finishButton = document.getElementById("finish-button");
  const commentList = document.getElementById("comments-list");
  const commentInput = document.getElementById("comment-input");
  const commentButton = document.getElementById("comment-button");
  const viewerCount = document.getElementById("viewer-count");
  const maxComments = 5; // Maximum number of displayed comments
  const estimatedViewers = 1000;
  guestRandomNumber = Math.floor(Math.random() * (estimatedViewers - 99 + 1)) + 99;

  video.controls = false; // Disable controls
  video.autoplay = false; // No autoplay

  updateViewerCount(); // Initial update
  function startVideo() {
    video.play();
    playButton.style.display = "none";
    joinButton.disabled = true;
    setInterval(addRandomComment, 3000); // Add random comment every 3 second
    setInterval(updateViewerCount, 5000); // Update every 5 seconds
  }

  playButton.addEventListener("click", startVideo);
  joinButton.addEventListener("click", startVideo);

  let commentCount = 0;

  commentButton.addEventListener("click", function() {
    if(joinButton.disabled !== false) {
      const commentText = commentInput.value.trim();
      if (commentText !== "") {
        addComment(commentText);
        commentInput.value = "";
      }
    } else {
      alert("You've to join first!");
    }
  });

  function addComment(text) {
    const profilePics = [
      "male.png",
      // Add more profile picture filenames here
    ];

    const names = [
      `Guest ${guestRandomNumber}`,
      // Add more names here
    ];

    const randomProfilePic = profilePics[Math.floor(Math.random() * profilePics.length)];
    const randomName = names[Math.floor(Math.random() * names.length)];

    const commentItem = document.createElement("li");
    commentItem.className = "comment-item";
    commentItem.innerHTML = `
      <div class="comment-avatar">
        <img src="img/${randomProfilePic}" alt="${randomName}'s profile picture">
      </div>
      <div class="comment-content">
        <p class="comment-name">${randomName}</p>
        <p class="comment-text">${text}</p>
      </div>
    `;

    commentList.appendChild(commentItem);
    commentCount++; // Increment the comment count
    if (commentCount > maxComments) {
      commentList.removeChild(commentList.firstElementChild);
    }
  }

  // Function to add random comments
  function addRandomComment() {
    if (commentCount >= maxComments) {
      // Remove the oldest comment if the maximum comment count is reached
      commentList.removeChild(commentList.firstElementChild);
    } else {
      commentCount++;
    }

    const profilePics = [
      "male.png",
      "female.png",
      "male.png"
      // Add more profile picture filenames here
    ];

    // const names = [
    //   "Alice",
    //   "Bob",
    //   "Charlie",
    //   "David",
    //   // Add more names here
    // ];

    const names = [
      // English Names
      "James", "Mary", "John", "Patricia", "Michael", "Jennifer", "David", "Linda", "Joseph", "Elizabeth",
      "William", "Susan", "Daniel", "Jessica", "Richard", "Sarah", "Matthew", "Karen", "Anthony", "Nancy",
      
      // Igbo Names
      "Chukwudi", "Chinwe", "Obinna", "Ada", "Ugochukwu", "Nkechi", "Chijioke", "Ifunanya", "Uche", "Chidinma",
      "Emeka", "Uju", "Ikenna", "Ngozi", "Nnamdi", "Chinyere", "Ifeoma", "Okechukwu", "Amaka", "Chiemeka",
      
      // Hausa Names
      "Abdullahi", "Aisha", "Muhammad", "Zainab", "Ibrahim", "Fatima", "Suleiman", "Hauwa", "Nasir", "Khadija",
      "Aliyu", "Safiya", "Ahmad", "Amina", "Mustafa", "Rukayya", "Usman", "Maryam", "Haruna", "Zainab",
      
      // Yoruba Names
      "Olumide", "Yetunde", "Adeolu", "Bolatito", "Adebayo", "Adebisi", "Oluwaseun", "Ayobami", "Olufemi", "Folake",
      "Oluwakemi", "Oluwatobi", "Olusegun", "Oluwabunmi", "Oluwatosin", "Oluwaseyi", "Adesola", "Oluwatoyin", "Oludare", "Oluwafemi"
    ];
    

    const comments = [
      "This livestream is amazing!",
      "Can't believe I'm here!",
      "Hello from the other side!",
      // Add more comments here
    ];

    const randomProfilePic = profilePics[Math.floor(Math.random() * profilePics.length)];
    const randomName = names[Math.floor(Math.random() * names.length)];
    const randomComment = comments[Math.floor(Math.random() * comments.length)];

    const commentItem = document.createElement("li");
    commentItem.className = "comment-item";
    commentItem.innerHTML = `
      <div class="comment-avatar">
        <img src="img/${randomProfilePic}" alt="${randomName}'s profile picture">
      </div>
      <div class="comment-content">
        <p class="comment-name">${randomName}</p>
        <p class="comment-text">${randomComment}</p>
      </div>
    `;

    commentList.appendChild(commentItem);
    // viewerCount.textContent = parseInt(viewerCount.textContent) + 1; // Increase viewer count
  }

  // Simulate updating viewer count within a specified range
  function updateViewerCount() {
    const userSuppliedNumber = estimatedViewers; // Example user-supplied number
    const lowerRange = Math.floor(userSuppliedNumber * 0.9); // 90% of user-supplied number
    const upperRange = Math.ceil(userSuppliedNumber * 1.2); // 120% of user-supplied number
    const randomViewers = Math.floor(Math.random() * (upperRange - lowerRange + 1)) + lowerRange;
    viewerCount.textContent = randomViewers;
  }

