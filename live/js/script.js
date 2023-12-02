
  var player;

  // Create a YouTube player
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '360',
      width: '640',
      videoId: 'H69g7NB8EeQ', // Replace with your actual video ID
      playerVars: {
        'autoplay': 0,        // Do not autoplay initially
        'controls': 0,        // Hide video controls
        'showinfo': 0,        // Hide video information
        'rel': 0,             // Do not show related videos
        'modestbranding': 1,  // Remove YouTube logo
        'playsinline': 1,     // Play the video inline on mobile devices
        'disablekb': 1        // Disable keyboard controls, including "Watch later" and "Share"
      }
    });

    // Add click event listener to the play button
    var playButton = document.getElementById('play-button');
    playButton.addEventListener('click', function() {
      player.playVideo();
    });
  }

const video = document.getElementById("livestream-video");
const registrationForm = document.getElementById("registration-form");
const videoContainer = document.querySelector(".video-container");
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
let commentCount = 0;

// video.controls = false; // Disable controls
// video.autoplay = true; // No autoplay


// Check if there's stored video progress and resume playback
// const storedVideoProgress = localStorage.getItem('videoProgress');
// if (storedVideoProgress !== null) {
//   video.currentTime = parseFloat(storedVideoProgress);
// }


updateViewerCount(); // Initial update
setInterval(addRandomComment, 3000); // Add random comment every 3 second
// video.addEventListener("timeupdate", checkVideoProgress); // Check video progress

function startVideo() {
  video.play();
  playButton.style.display = "none";
  joinButton.disabled = true;
  setInterval(updateViewerCount, 5000); // Update every 5 seconds
}

const hasWatchedVideo = localStorage.getItem('hasWatchedVideo')

if(hasWatchedVideo) {
  registrationForm.style.display = "none";
  videoContainer.style.display = "block";
} else {
  registrationForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    // Make an API request before showing the video
    try {
      
      await fetch('https://avalmails.afobe.net/api/email-contacts/store-api', {
        method: 'POST', // Adjust the HTTP method as needed
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          "owner_id": 55,
          "name": document.getElementById("name").value,
          "email": document.getElementById("email").value,
          "country_code": document.getElementById("countryCode").value,
          "phone": document.getElementById("phoneNumber").value,
          "tags": "one_webinar"
        }),    
      })
      .then(response => {
        if (response.ok) {
          // API call successful, proceed with the following steps
          localStorage.setItem('hasWatchedVideo', true);
          registrationForm.style.display = "none";
          videoContainer.style.display = "block";
          startVideo();
        } else if (response.status === 422) {
          // API returns a specific error status (422 in this case)
          return response.json()
          .then(errorData => {
            // Log the error message received from the API
            console.error('API error:', errorData.error);
            return Promise.reject('API error'); // Return a rejected Promise
          });
        } else {
          // Handle API error here, e.g., show an error message
          console.error('API request failed');
        }
      })
    } catch (error) {
      console.error('Network error:', error);
    }
  });
}

playButton.addEventListener("click", startVideo);
joinButton.addEventListener("click", startVideo);

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
    // English-Neutral Names
    "Alex", "Jordan", "Taylor", "Sam", "Casey", "Morgan", "Dakota", "Avery", "Riley", "Quinn",
    
    // Igbo-Neutral Names
    "Chioma", "Chinonso", "Chizoba", "Obioma", "Uzoma", "Uchenna", "Kenechukwu", "Onyekachi", "Ogechukwu", "Chukwudi",
    
    // Hausa-Neutral Names
    "Zahra", "Kamal", "Nur", "Zain", "Idris", "Amin", "Musa", "Nasir", "Kadija", "Jamila",
    
    // Yoruba-Neutral Names
    "Taiwo", "Kehinde", "Dapo", "Ayomide", "Oluwaseun", "Oyin", "Opeyemi", "Oluwadamilola", "Oluwadare", "Adebola"
  ];
  
  

  const comments = [
    "Nice to be here. I'm excited to learn!",
    "Another word of wisdom shared. Thank you!",
    "Straight to the point. Great content!",
    "It's amazing learning from you. Keep it up!",
    "So happy I subscribed to you. Always inspiring.",
    "This livestream is fantastic! I'm engaged.",
    "Your insights are always thought-provoking.",
    "Thank you for sharing your knowledge!",
    "I look forward to your livestreams every time.",
    "Incredibly informative. Thanks for your time!",
    "I'm learning so much from your livestreams.",
    "Your explanations are always so clear.",
    "This is exactly what I needed to hear today.",
    "You make complex concepts easy to understand.",
    "You have a great way of breaking things down.",
    "Your livestreams are a valuable resource.",
    "I appreciate your dedication to teaching.",
    "Thank you for your passion and expertise.",
    "I'm taking notes. This is gold!",
    "So glad I stumbled upon your livestream.",
    "You've helped me see things in a new light.",
    "Every livestream is a learning opportunity.",
    "You're making a positive impact. Keep it up!",
    "Your livestreams are a highlight of my day.",
    "I feel more informed after every session.",
    "I love the way you share your insights.",
    "Thank you for sharing your wisdom with us.",
    "This livestream is like a breath of fresh air.",
    "You're helping me grow and learn. Thank you!",
    "I'm inspired by your dedication to teaching.",
    "Your livestreams are time well spent.",
    "Your advice is always practical and helpful.",
    "You have a great way of connecting with your audience.",
    "I'm grateful for the knowledge you share.",
    "Your livestreams are a source of motivation.",
    "Your content resonates with me deeply.",
    "I'm impressed by your expertise and clarity.",
    "You have a gift for explaining complex ideas.",
    "This livestream is a valuable learning experience.",
    "I appreciate the effort you put into your livestreams.",
    "You're helping us become better learners.",
    "Your livestreams are like masterclasses.",
    "Your insights are changing the way I think.",
    "This livestream is a highlight of my week.",
    "Your dedication to education is inspiring.",
    "You're making a difference with your livestreams.",
    "Thank you for sharing your knowledge so generously.",
    "I'm learning something new every time I watch.",
    "Your livestreams are a wealth of information.",
    "I'm enjoying this engaging and informative livestream.",
    "Your wisdom is greatly appreciated.",
    "You're a true educator. Thank you!",
    "This livestream is a treasure trove of insights.",
    "Your livestreams make learning enjoyable.",
    "I'm grateful for the inspiration you provide.",
    "You're helping me expand my horizons.",
    "Your livestreams are a gift to your audience.",
    "I'm thankful for your commitment to teaching.",
    "You're changing lives through your livestreams.",
    "Your passion for education is contagious.",
    "I'm soaking up every bit of knowledge.",
    "This livestream is a valuable resource for me.",
    "Your expertise shines through in every session.",
    "You're making complex topics accessible to all.",
    "I appreciate the effort you put into preparation.",
    "Your livestreams are like a masterclass in learning.",
    "You're creating a supportive learning community.",
    "This livestream is a safe space for growth.",
    "Your insights are helping me evolve.",
    "You're doing a fantastic job as an educator.",
    "I'm learning and growing with every livestream.",
    "Your content is enriching and enlightening.",
    "You're making a real impact with your livestreams.",
    "This livestream is a valuable source of information.",
    "Your knowledge and enthusiasm are contagious.",
    "You're helping us become better thinkers.",
    "This livestream is a haven of inspiration.",
    "Your dedication to sharing knowledge is admirable.",
    "You're shaping minds and perspectives.",
    "This livestream is a journey of learning.",
    "Your insights are sparking curiosity.",
    "You're making learning an enjoyable experience.",
    "This livestream is a goldmine of wisdom.",
    "Your content resonates deeply with me.",
    "You're a beacon of knowledge and guidance.",
    "This livestream is like a treasure chest of insights.",
    "Your enthusiasm for teaching is inspiring.",
    "You're fostering a culture of continuous learning.",
    "This livestream is a catalyst for growth.",
    "Your livestreams are a testament to your expertise.",
    "You're igniting a passion for learning in us.",
    "This livestream is a source of empowerment.",
    "Your insights are shaping a brighter future.",
    "You're making complex topics digestible.",
    "This livestream is a bridge to understanding.",
    "Your dedication to teaching is commendable.",
    "You're helping us become lifelong learners.",
    "This livestream is a gift to curious minds.",
    "Your content is making a real impact.",
    "You're helping us navigate a world of knowledge.",
    "This livestream is a valuable learning journey.",
    "Your insights are a breath of fresh perspective.",
    "You're creating a ripple effect of learning.",
    "This livestream is a fountain of wisdom.",
    "Your dedication to education is changing lives."
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

function addNiceComment() {
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
    // English-Neutral Names
    "Alex", "Jordan", "Taylor", "Sam", "Casey", "Morgan", "Dakota", "Avery", "Riley", "Quinn",
    
    // Igbo-Neutral Names
    "Chioma", "Chinonso", "Chizoba", "Obioma", "Uzoma", "Uchenna", "Kenechukwu", "Onyekachi", "Ogechukwu", "Chukwudi",
    
    // Hausa-Neutral Names
    "Zahra", "Kamal", "Nur", "Zain", "Idris", "Amin", "Musa", "Nasir", "Kadija", "Jamila",
    
    // Yoruba-Neutral Names
    "Taiwo", "Kehinde", "Dapo", "Ayomide", "Oluwaseun", "Oyin", "Opeyemi", "Oluwadamilola", "Oluwadare", "Adebola"
  ];
  
  

  const comments = [
    "I will subscribe straight away!",
    "Count me in. Paying for this straight up!",
    "This content is worth every penny.",
    "Signing up for the premium experience!",
    "I'm becoming a member right after this!"
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


function checkVideoProgress() {
  const videoProgress = (video.currentTime / video.duration) * 100;
  if (videoProgress >= 30 && !commentButton.disabled) {
    addNiceComment(); // Add comments at 30% towards the end
  }

  // Store the video progress in local storage
  localStorage.setItem('videoProgress', video.currentTime);
}

video.addEventListener("ended", function() {
  // Redirect to the desired URL when the video ends
  console.log("Video has ended."); 
  window.location.href = "./?end=1"; // Replace with your desired URL
});
