  const video = document.getElementById("livestream-video");
  const playButton = document.getElementById("play-button");
  const joinButton = document.getElementById("join-button");
  const finishButton = document.getElementById("finish-button");
  const commentList = document.getElementById("comments-list");
  const viewerCount = document.getElementById("viewer-count");
  const maxComments = 5; // Maximum number of displayed comments
  const estimatedViewers = 1000;

  video.controls = false; // Disable controls
  video.autoplay = false; // No autoplay

  function startVideo() {
    video.play();
    playButton.style.display = "none";
    joinButton.style.display = "none";
    finishButton.classList.remove("d-none");
    setInterval(addRandomComment, 3000); // Add random comment every 3 second
    updateViewerCount(); // Initial update
    setInterval(updateViewerCount, 5000); // Update every 5 seconds
  }

  playButton.addEventListener("click", startVideo);
  joinButton.addEventListener("click", startVideo);

  let commentCount = 0;

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

    const names = [
      "Alice",
      "Bob",
      "Charlie",
      "David",
      // Add more names here
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

