document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ student_friends.js loaded");

  const tabs = document.querySelectorAll(".tab");
  const contents = document.querySelectorAll(".friends-content");

  // === Tab Switching ===
  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => t.classList.remove("active"));
      contents.forEach((c) => c.classList.add("hidden"));
      tab.classList.add("active");
      document.getElementById(tab.dataset.tab + "-content").classList.remove("hidden");
    });
  });

  // === Reload sections ===
  async function reloadFriends() {
    console.log("🔄 Reloading friends...");
    const res = await fetch("search_friends.php", { method: "POST" });
    document.getElementById("friends-table-body").innerHTML = await res.text();
  }

  async function reloadRequests() {
    console.log("🔄 Reloading requests...");
    const res = await fetch("search_requests.php", { method: "POST" });
    document.getElementById("requests-table-body").innerHTML = await res.text();
  }

  async function reloadSearch(query = "") {
    console.log("🔄 Reloading people search:", query);
    const res = await fetch("search_students.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ q: query }),
    });
    document.getElementById("search-results").innerHTML = await res.text();
  }

  // === Friend Search (Friend List tab) ===
  const friendSearch = document.getElementById("friend-search");
  if (friendSearch) {
    friendSearch.addEventListener("input", async (e) => {
      await reloadFriends(e.target.value);
    });
  }

  // === People Search (Search People tab) ===
  const peopleSearch = document.getElementById("people-search");
  if (peopleSearch) {
    peopleSearch.addEventListener("input", async (e) => {
      await reloadSearch(e.target.value);
    });
  }

  // === Delegated Action Buttons ===
  document.body.addEventListener("click", async (e) => {
    const id = e.target.dataset.id;

    // --- Unfriend ---
    if (e.target.matches(".unfriend-btn")) {
      console.log("🟡 Unfriend clicked:", id);
      await fetch("student_friends.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=unfriend&target_id=${id}`,
      });
      await reloadFriends();
    }

    // --- Send Friend Request ---
    if (e.target.matches(".add-request-btn")) {
      console.log("🟡 Add Friend clicked:", id);
      await fetch("student_friends.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=add-request&target_id=${id}`,
      });
      await reloadSearch(peopleSearch?.value || "");
    }

    // --- Accept Friend Request ---
    if (e.target.matches(".accept-request-btn")) {
      console.log("🟡 Accept clicked:", id);
      await fetch("student_friends.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=accept-request&target_id=${id}`,
      });
      await reloadRequests();
      await reloadFriends();
    }

    // --- Reject Friend Request ---
    if (e.target.matches(".reject-request-btn")) {
      console.log("🟡 Reject clicked:", id);
      await fetch("student_friends.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=reject-request&target_id=${id}`,
      });
      await reloadRequests();
    }
  });
});
