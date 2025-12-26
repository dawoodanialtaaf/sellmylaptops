<?php
// voice-search.php - Voice Search Integration for SellMyLaptops.com

// Output the voice search JavaScript
echo '
<!-- Voice Search Script for SellMyLaptops.com -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Find all search inputs in your sellmylaptops theme
  const searchInput = document.querySelector(\'input[name="search"]\') || 
                     document.querySelector(\'.srch_list_of_model\') ||
                     document.querySelector(\'form[action*="search"] input[type="text"]\') ||
                     document.querySelector(\'.d-header-search input[name="q"]\') || 
                     document.querySelector(\'.header-search input[name="q"]\') ||
                     document.querySelector(\'input[name="q"]\');
  
  if (!searchInput) return;

  // Create the microphone button
  const micBtn = document.createElement("button");
  micBtn.setAttribute("id", "voiceSearchBtn");
  micBtn.setAttribute("type", "button");
  micBtn.setAttribute("aria-label", "Click to search by voice");
  micBtn.setAttribute("title", "Click to search by voice");
  
  // Style the button to match your theme
  micBtn.style.cssText = `
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 16px;
    vertical-align: middle;
    padding: 4px 6px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    min-width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #666;
  `;
  
  micBtn.innerHTML = "🎤";

  // Add hover effect
  micBtn.addEventListener("mouseenter", function() {
    this.style.backgroundColor = "rgba(0,0,0,0.1)";
  });
  
  micBtn.addEventListener("mouseleave", function() {
    this.style.backgroundColor = "transparent";
  });

  // Make the input container relative positioned and insert button
  const inputContainer = searchInput.parentNode;
  if (inputContainer) {
    inputContainer.style.position = "relative";
    inputContainer.appendChild(micBtn);
    
    // Add padding to input to make room for mic button
    searchInput.style.paddingRight = "40px";
  }

  // Voice search functionality
  micBtn.addEventListener("click", function () {
    if (!(\'webkitSpeechRecognition\' in window || \'SpeechRecognition\' in window)) {
      alert("Voice search is not supported in your browser. Please try Chrome, Safari, or Edge.");
      return;
    }

    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = "en-US";
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    // Visual feedback
    const originalPlaceholder = searchInput.placeholder;
    micBtn.innerHTML = "🔴";
    micBtn.style.animation = "pulse 1s infinite";
    searchInput.placeholder = "Listening...";
    
    // Add pulse animation if it doesn\'t exist
    if (!document.getElementById(\'voice-search-styles\')) {
      const style = document.createElement(\'style\');
      style.id = \'voice-search-styles\';
      style.textContent = `
        @keyframes pulse {
          0% { transform: translateY(-50%) scale(1); }
          50% { transform: translateY(-50%) scale(1.1); }
          100% { transform: translateY(-50%) scale(1); }
        }
      `;
      document.head.appendChild(style);
    }

    recognition.start();

    recognition.onresult = function (event) {
      const rawTranscript = event.results[0][0].transcript;
      
      // Reset button appearance but keep processing indicator
      micBtn.innerHTML = "🎤";
      micBtn.style.animation = "";
      searchInput.placeholder = "Processing voice...";

      // **REPLACE WITH YOUR ACTUAL OPENAI API KEY**
      const OPENAI_API_KEY = \'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\';
      
      console.log(\'Raw voice input:\', rawTranscript);
      
      // SellMyLaptops.com optimized prompt
      fetch("https://api.openai.com/v1/chat/completions", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${OPENAI_API_KEY}`
        },
        body: JSON.stringify({
          model: "gpt-4o-mini",
          messages: [
            { 
              role: "user", 
              content: `You are a laptop and electronics search specialist for sellmylaptops.com. Convert the customer\'s spoken request into the most relevant search terms for finding used laptops, refurbished electronics, and electronic components for sale.

PRODUCT CATEGORIES TO CONSIDER:
- Laptops: used, refurbished, gaming, business, ultrabook, 2-in-1, touchscreen
- Desktop Computers: tower, all-in-one, mini PC, workstation, gaming PC
- Components: motherboard, CPU, GPU, graphics card, RAM, SSD, HDD, power supply
- Monitors: LCD, LED, OLED, curved, gaming, 4K, ultrawide, dual monitor
- Mobile Devices: smartphones, tablets, iPad, Android, iPhone, Samsung
- Peripherals: keyboard, mouse, webcam, speakers, headphones, microphone
- Networking: router, modem, WiFi, ethernet, network card, access point
- Storage: external drive, USB drive, memory card, backup drive, NAS
- Cables & Adapters: USB, HDMI, DisplayPort, charging cable, converter
- Servers: rack server, blade server, enterprise hardware

LAPTOP BRANDS & MODELS TO RECOGNIZE:
- Business: Dell Latitude, Lenovo ThinkPad, HP EliteBook, HP ProBook
- Gaming: Alienware, MSI Gaming, Asus ROG, Acer Predator, Razer Blade
- Consumer: Dell Inspiron, HP Pavilion, Lenovo IdeaPad, Asus ZenBook, Acer Aspire
- Premium: MacBook Pro, MacBook Air, Microsoft Surface, Dell XPS, HP Spectre
- Workstation: Dell Precision, HP ZBook, Lenovo ThinkPad P-series

CONDITION & SPECIFICATION TERMS:
- Condition: used, refurbished, like new, excellent, good, fair, parts only
- Specifications: Intel, AMD, Ryzen, Core i3/i5/i7/i9, RAM, SSD, HDD, screen size
- Features: touchscreen, backlit keyboard, fingerprint, webcam, gaming, business

SEARCH OPTIMIZATION RULES:
- Include brand and model series when mentioned
- Add condition preferences (used, refurbished, etc.)
- Include specifications like RAM, storage, screen size
- Add use case terms: gaming, business, student, professional
- Remove buying intent words: "want to buy", "looking to purchase", "need"
- Include both specific model and general category terms
- Add relevant technical specifications
- Include price-related terms when mentioned

EXAMPLES:
"I want to buy a gaming laptop" → "gaming laptop used refurbished MSI Asus ROG"
"Looking for a used MacBook Pro" → "MacBook Pro used refurbished laptop"
"Need a cheap laptop for school" → "cheap laptop student used refurbished budget"
"Want to buy a ThinkPad for work" → "ThinkPad business laptop used Lenovo"
"Looking for a graphics card for gaming" → "graphics card GPU gaming used refurbished"
"Need a monitor for my setup" → "monitor LCD LED used refurbished"
"Want to sell my old iPhone" → "iPhone smartphone used trade-in"
"Looking for Dell desktop computer" → "Dell desktop computer tower used refurbished"
"Need RAM for my laptop upgrade" → "laptop RAM memory upgrade DDR4 SO-DIMM"
"Want a 4K monitor cheap" → "4K monitor used refurbished cheap budget"
"Looking for wireless mouse and keyboard" → "wireless mouse keyboard set used"
"Need external hard drive storage" → "external hard drive storage backup used"
"Want to buy server equipment" → "server equipment enterprise hardware used"
"Looking for tablet like iPad" → "tablet iPad Android used refurbished"
"Need laptop charger for HP" → "HP laptop charger adapter power supply"

Convert this customer request to relevant electronics search keywords: "${rawTranscript}"` 
            }
          ],
          max_tokens: 25,
          temperature: 0.1
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`API Error: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        let optimizedQuery = data.choices?.[0]?.message?.content?.trim() || rawTranscript;
        
        // Clean up the response
        optimizedQuery = optimizedQuery
          .replace(/^["\'"]|["\'"]$/g, \'\')
          .replace(/^(Keywords only:|Keywords:|Output:|Search:)/i, \'\')
          .replace(/[.!?]$/, \'\')
          .replace(/\\n/g, \' \')
          .replace(/\\s+/g, \' \')
          .trim();
        
        console.log(\'Optimized query:\', optimizedQuery);
        
        // Set the optimized query in the search field
        searchInput.value = optimizedQuery;
        searchInput.placeholder = originalPlaceholder;
        
        // Show brief feedback to user
        searchInput.placeholder = "Searching...";
        
        // Auto-submit the optimized query
        const searchForm = searchInput.closest(\'form\');
        setTimeout(() => {
          if (searchForm) {
            searchForm.submit();
          }
        }, 500);
        
      })
      .catch(error => {
        console.error(\'Voice search error:\', error);
        // Fallback: use original transcript
        searchInput.value = rawTranscript;
        searchInput.placeholder = "Searching...";
        const searchForm = searchInput.closest(\'form\');
        setTimeout(() => {
          if (searchForm) {
            searchForm.submit();
          }
        }, 500);
      });
    };

    recognition.onerror = function(event) {
      console.error(\'Speech recognition error:\', event.error);
      micBtn.innerHTML = "🎤";
      micBtn.style.animation = "";
      searchInput.placeholder = originalPlaceholder;
      
      if (event.error === \'no-speech\') {
        alert(\'No speech detected. Please try again.\');
      } else if (event.error === \'not-allowed\') {
        alert(\'Microphone access denied. Please allow microphone access and try again.\');
      } else {
        alert(\'Voice recognition error. Please try again.\');
      }
    };

    recognition.onend = function() {
      micBtn.innerHTML = "🎤";
      micBtn.style.animation = "";
      if (searchInput.placeholder === "Listening...") {
        searchInput.placeholder = originalPlaceholder;
      }
    };
  });

  // Handle mobile touch events
  micBtn.addEventListener("touchstart", function(e) {
    e.preventDefault();
    this.click();
  });

  // Add voice search to additional search inputs found later
  setTimeout(function() {
    const additionalSearchInputs = document.querySelectorAll(\'input[name="search"], .srch_list_of_model\');
    additionalSearchInputs.forEach((input, index) => {
      if (input !== searchInput && !input.hasVoiceButton) {
        input.hasVoiceButton = true;
        
        // Clone the voice functionality for additional inputs
        const additionalMicBtn = micBtn.cloneNode(true);
        additionalMicBtn.setAttribute("id", `voiceSearchBtn_${index}`);
        
        const additionalInputContainer = input.parentNode;
        if (additionalInputContainer) {
          additionalInputContainer.style.position = "relative";
          additionalInputContainer.appendChild(additionalMicBtn);
          input.style.paddingRight = "40px";
          
          // Copy event listeners to additional button
          additionalMicBtn.addEventListener("click", function() {
            // Set the current search input context
            const currentInput = input;
            micBtn.click.call({ searchInput: currentInput });
          });
        }
        
        console.log(\'Additional voice search added\');
      }
    });
  }, 2000);
});
</script>
';
?>