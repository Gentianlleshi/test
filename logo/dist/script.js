document.addEventListener("DOMContentLoaded", function () {
  const categoryTabs = document.querySelectorAll(".benefits-category-tab");
  const tagCheckboxes = document.querySelectorAll(".benefits-tag-filter");
  const resultsContainer = document.getElementById("benefits-results");
  const loadMoreBtn = document.getElementById("load-more-btn");

  // Use the initial category from the localized script
  let activeCategory = ajax_object.initial_category || "";
  let postsPerPage = 6;
  let currentPage = 1;
  let loadingMore = false;

  // Initialize inactiveTags with unchecked tag values
  let inactiveTags = Array.from(tagCheckboxes)
    .filter((checkbox) => !checkbox.checked)
    .map((checkbox) => checkbox.value);

  function fetchBenefits(loadMore = false) {
    if (loadMore && loadingMore) return;
    if (loadMore) loadingMore = true;

    const params = new URLSearchParams();
    params.append("action", "filter_benefits");
    params.append("category", activeCategory);
    params.append("posts_per_page", postsPerPage);
    params.append("page", currentPage);
    inactiveTags.forEach((tag) => params.append("inactive_tags[]", tag));

    fetch(ajax_object.ajax_url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: params.toString(),
    })
      .then((response) => response.text())
      .then((data) => {
        if (loadMore) {
          // Append the new posts
          resultsContainer.insertAdjacentHTML("beforeend", data);
          loadingMore = false;
        } else {
          // Replace the current posts
          resultsContainer.innerHTML = data;
          currentPage = 1; // Reset to first page
          // Update Load More button visibility
          // updateLoadMoreVisibility();
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        if (loadMore) loadingMore = false;
      });
  }

  categoryTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      activeCategory = this.getAttribute("data-category");
      categoryTabs.forEach((t) => t.classList.remove("active"));
      this.classList.add("active");
      currentPage = 1; // Reset to first page
      fetchBenefits();
    });
  });

  tagCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      // Update inactiveTags when checkboxes change
      inactiveTags = Array.from(tagCheckboxes)
        .filter((checkbox) => !checkbox.checked)
        .map((checkbox) => checkbox.value);
      currentPage = 1; // Reset to first page
      fetchBenefits();
    });
  });

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      currentPage++;
      fetchBenefits(true);
    });
  }

  // Initial fetch is not needed since the initial posts are already loaded
  // But we need to update the Load More button visibility
  // updateLoadMoreVisibility();
});
