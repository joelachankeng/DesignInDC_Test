//main.js file
let data = [];

const gamesTable = $("#games-table");
const pagination = $("#pagination");
const pageTitle = $("#page-title").clone(true);

const loadingRow = $("#loading-row").clone(true);
const modalError = $("#modal-error");

const renderGames = () => {
  const rows = [];
  data.response.forEach((game) => {
    const gameDate = new Date(game.date.start);
    const readableDate = gameDate
      .toLocaleString("en-US", {
        timeZone: "UTC",
      })
      .split(",")[0];
    const dataDate = game.date.start.split("T")[0];

    const row = `
        <tr>
            <th scope="row">${game.id}</th>
            <td>
                <button type="button" class="btn btn-primary date-btn" data-date="${dataDate}">
                    ${readableDate}
                </button>
            </td>
            <td>${game.teams.home.name} <b>VS.</b> ${game.teams.visitors.name}</td>
            <td>${game.status.long}</td>
            <td>${game.scores.home.points} - ${game.scores.visitors.points}</td>
            <td>${game.arena.name}</td>
        </tr>
    `;
    rows.push(row);
  });
  gamesTable.find("tbody").html("");
  gamesTable.find("tbody").append(rows);
};

const updatePagination = () => {
  const limit = 2;
  pagination.find("ul").html("");
  pagination.addClass("d-none");

  for (
    let pageNumber = data.page.current;
    pageNumber < data.page.total;
    pageNumber++
  ) {
    const index = pageNumber;

    const paginationItem = $(`
        <li class="page-item">
            <a class="page-link" href="#" data-page="${index}">${index}</a>
        </li>
    `);

    if (pageNumber === data.page.current) {
      paginationItem.addClass("active");
    }

    pagination.find("ul").append(paginationItem);

    if (pageNumber === data.page.current + limit) {
      break;
    }
  }
  const prevItem = $(`
    <li class="page-item">
        <a id="prev-page" class="page-link" href="#">Previous</a>
    </li>
    `);

  const nextItem = $(`
    <li class="page-item">
        <a id="next-page" class="page-link" href="#">Next</a>
    </li>
    `);

  if (data.page.current === 1) {
    prevItem.addClass("disabled");
  }

  if (data.page.current === data.page.total) {
    nextItem.addClass("disabled");
  }

  pagination.find("ul").prepend(prevItem);
  pagination.find("ul").append(nextItem);

  pagination.removeClass("d-none");
};

const getGames = ($page = 1, $date = null) => {
  if ($page < 1) {
    $page = 1;
  }

  if (isNaN($page)) {
    $page = 1;
  }

  const getData = {
    page: $page,
  };

  if ($date) getData.date = $date;

  gamesTable.find("tbody").html("");
  gamesTable.find("tbody").append(loadingRow.clone(true));
  $.ajax({
    url: "/api/games",
    type: "GET",
    dataType: "json",
    data: getData,
    success: function (response) {
      $("#loading-row").hide();
      console.log(response);
      data = response;
      renderGames();
      updatePagination();
    },
    error: function (err) {
      $("#loading-row").hide();
      $("#modal-error").addClass("show");
    },
  });
};

$(document).ready(function () {
  getGames();
});

$(document).on("click", ".page-link", function (e) {
  e.preventDefault();
  if ($(this).hasClass("active")) return;

  if ($(this).attr("id") === "next-page") {
    const page = data.page.current + 1;
    getGames(page);
    return;
  }

  if ($(this).attr("id") === "prev-page") {
    const page = data.page.current - 1;
    getGames(page);
    return;
  }

  const page = $(this).data("page");
  getGames(page);
});

$(document).on("click", ".date-btn", function (e) {
  e.preventDefault();
  const date = $(this).data("date");
  const gameDate = new Date(date);

  if (isNaN(gameDate.getTime())) {
    $("#modal-error").addClass("show");
    return;
  }

  const readableDate = gameDate
    .toLocaleString("en-US", {
      timeZone: "UTC",
    })
    .split(",")[0];

  getGames(1, date);

  $("#view-all-btn").removeClass("d-none");
  $("#page-title").text("All Games on " + readableDate);
});

$(document).on("click", "#view-all-btn", function (e) {
  e.preventDefault();
  getGames();
  $("#view-all-btn").addClass("d-none");
  $("#page-title").replaceWith(pageTitle.clone(true));
});
