"use strict";
let direction = "ltr";
isRtl && (direction = "rtl"),
  document.addEventListener("DOMContentLoaded", function () {
    {
      const f = document.getElementById("calendar"),
        g = document.querySelector(".app-calendar-sidebar"),
        h = document.getElementById("addEventSidebar"),
        b = document.querySelector(".app-overlay"),
        y = {
          Business: "primary",
          Holiday: "success",
          Personal: "danger",
          Family: "warning",
          ETC: "info",
        },
        S = document.querySelector(".offcanvas-title"),
        L = document.querySelector(".btn-toggle-sidebar"),
        E = document.querySelector(".btn-add-event"),
        k = document.querySelector(".btn-update-event"),
        w = document.querySelector(".btn-delete-event"),
        x = document.querySelector(".btn-cancel"),
        q = document.querySelector("#eventTitle"),
        D = document.querySelector("#eventStartDate"),
        P = document.querySelector("#eventEndDate"),
        M = document.querySelector("#eventURL"),
        T = $("#eventLabel"),
        A = $("#eventGuests"),
        F = document.querySelector("#eventLocation"),
        Y = document.querySelector("#eventDescription"),
        C = document.querySelector(".allDay-switch"),
        V = document.querySelector(".select-all"),
        B = [].slice.call(document.querySelectorAll(".input-filter")),
        I = document.querySelector(".inline-calendar");
      let a,
        l = events,
        r = !1,
        e;
      const R = new bootstrap.Offcanvas(h);
      function t(e) {
        return e.id
          ? "<span class='badge badge-dot bg-" +
              $(e.element).data("label") +
              " me-2'> </span>" +
              e.text
          : e.text;
      }
      function n(e) {
        return e.id
          ? "<div class='d-flex flex-wrap align-items-center'><div class='avatar avatar-xs me-2'><img src='" +
              assetsPath +
              "img/avatars/" +
              $(e.element).data("avatar") +
              "' alt='avatar' class='rounded-circle' /></div>" +
              e.text +
              "</div>"
          : e.text;
      }
      var d, o;
      function s() {
        const e = document.querySelector(".fc-sidebarToggle-button");
        for (
          e.classList.remove("fc-button-primary"),
            e.classList.add("d-lg-none", "d-inline-block", "ps-0");
          e.firstChild;

        )
          e.firstChild.remove();
        e.setAttribute("data-bs-toggle", "sidebar"),
          e.setAttribute("data-overlay", ""),
          e.setAttribute("data-target", "#app-calendar-sidebar"),
          e.insertAdjacentHTML("beforeend", '<i class="bx bx-menu bx-sm"></i>');
      }
      T.length &&
        T.wrap('<div class="position-relative"></div>').select2({
          placeholder: "Select value",
          dropdownParent: T.parent(),
          templateResult: t,
          templateSelection: t,
          minimumResultsForSearch: -1,
          escapeMarkup: function (e) {
            return e;
          },
        }),
        A.length &&
          A.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select value",
            dropdownParent: A.parent(),
            closeOnSelect: !1,
            templateResult: n,
            templateSelection: n,
            escapeMarkup: function (e) {
              return e;
            },
          }),
        D &&
          (d = D.flatpickr({
            enableTime: !0,
            altFormat: "Y-m-dTH:i:S",
            onReady: function (e, t, n) {
              n.isMobile && n.mobileInput.setAttribute("step", null);
            },
          })),
        P &&
          (o = P.flatpickr({
            enableTime: !0,
            altFormat: "Y-m-dTH:i:S",
            onReady: function (e, t, n) {
              n.isMobile && n.mobileInput.setAttribute("step", null);
            },
          })),
        I && (e = I.flatpickr({ monthSelectorType: "static", inline: !0 }));
      var {
        dayGrid: c,
        interaction: u,
        timeGrid: v,
        list: m,
      } = calendarPlugins;
      let i = new Calendar(f, {
        initialView: "dayGridMonth",
        events: function (e, t) {
          let n = (function () {
            let t = [],
              e = [].slice.call(
                document.querySelectorAll(".input-filter:checked")
              );
            return (
              e.forEach((e) => {
                t.push(e.getAttribute("data-value"));
              }),
              t
            );
          })();
          t(
            l.filter(function (e) {
              return n.includes(e.extendedProps.calendar.toLowerCase());
            })
          );
        },
        plugins: [u, c, v, m],
        editable: !0,
        dragScroll: !0,
        dayMaxEvents: 2,
        eventResizableFromStart: !0,
        customButtons: { sidebarToggle: { text: "Sidebar" } },
        headerToolbar: {
          start: "sidebarToggle, prev,next, title",
          end: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
        },
        direction: direction,
        initialDate: new Date(),
        navLinks: !0,
        eventClassNames: function ({ event: e }) {
          return ["fc-event-" + y[e._def.extendedProps.calendar]];
        },
        dateClick: function (e) {
          e = moment(e.date).format("YYYY-MM-DD");
          p(),
            R.show(),
            S && (S.innerHTML = "Add Event"),
            E.classList.remove("d-none"),
            k.classList.add("d-none"),
            w.classList.add("d-none"),
            (D.value = e),
            (P.value = e);
        },
        eventClick: function (e) {
          (e = e),
            (a = e.event).url &&
              (e.jsEvent.preventDefault(), window.open(a.url, "_blank")),
            R.show(),
            E.classList.add("d-none"),
            k.classList.remove("d-none"),
            S && (S.innerHTML = "Update Event"),
            w.classList.remove("d-none"),
            (q.value = a.title),
            d.setDate(a.start, !0, "Y-m-d"),
            !0 === a.allDay ? (C.checked = !0) : (C.checked = !1),
            null !== a.end
              ? o.setDate(a.end, !0, "Y-m-d")
              : o.setDate(a.start, !0, "Y-m-d"),
            T.val(a.extendedProps.calendar).trigger("change"),
            void 0 !== a.extendedProps.location &&
              (F.value = a.extendedProps.location),
            void 0 !== a.extendedProps.guests &&
              A.val(a.extendedProps.guests).trigger("change"),
            void 0 !== a.extendedProps.description &&
              (Y.value = a.extendedProps.description);
        },
        datesSet: function () {
          s();
        },
        viewDidMount: function () {
          s();
        },
      });
      function p() {
        (P.value = ""),
          (M.value = ""),
          (D.value = ""),
          (q.value = ""),
          (F.value = ""),
          (C.checked = !1),
          A.val("").trigger("change"),
          (Y.value = "");
      }
      return (
        i.render(),
        s(),
        (u = document.getElementById("eventForm")),
        FormValidation.formValidation(u, {
          fields: {
            eventTitle: {
              validators: {
                notEmpty: { message: "Please enter event title " },
              },
            },
            eventStartDate: {
              validators: { notEmpty: { message: "Please enter start date " } },
            },
            eventEndDate: {
              validators: { notEmpty: { message: "Please enter end date " } },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
              eleValidClass: "",
              rowSelector: function (e, t) {
                return ".mb-3";
              },
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus(),
          },
        }).on("core.form.valid", function () {
          r = !0;
        }),
        L &&
          L.addEventListener("click", (e) => {
            x.classList.remove("d-none");
          }),
        E.addEventListener("click", (e) => {
          if (r) {
            let e = {
              id: i.getEvents().length + 1,
              title: q.value,
              start: D.value,
              end: P.value,
              startStr: D.value,
              endStr: P.value,
              display: "block",
              extendedProps: {
                location: F.value,
                guests: A.val(),
                calendar: T.val(),
                description: Y.value,
              },
            };
            M.value && (e.url = M.value),
              C.checked && (e.allDay = !0),
              (t = e),
              l.push(t),
              i.refetchEvents(),
              R.hide();
          }
          var t;
        }),
        k.addEventListener("click", (e) => {
          var t, n;
          r &&
            ((t = {
              id: a.id,
              title: q.value,
              start: D.value,
              end: P.value,
              url: M.value,
              extendedProps: {
                location: F.value,
                guests: A.val(),
                calendar: T.val(),
                description: Y.value,
              },
              display: "block",
              allDay: !!C.checked,
            }),
            ((n = t).id = parseInt(n.id)),
            (l[l.findIndex((e) => e.id === n.id)] = n),
            i.refetchEvents(),
            R.hide());
        }),
        w.addEventListener("click", (e) => {
          var t;
          (t = parseInt(a.id)),
            (l = l.filter(function (e) {
              return e.id != t;
            })),
            i.refetchEvents(),
            R.hide();
        }),
        h.addEventListener("hidden.bs.offcanvas", function () {
          p();
        }),
        L.addEventListener("click", (e) => {
          w.classList.add("d-none"),
            k.classList.add("d-none"),
            E.classList.remove("d-none"),
            g.classList.remove("show"),
            b.classList.remove("show");
        }),
        V &&
          V.addEventListener("click", (e) => {
            e.currentTarget.checked
              ? document
                  .querySelectorAll(".input-filter")
                  .forEach((e) => (e.checked = 1))
              : document
                  .querySelectorAll(".input-filter")
                  .forEach((e) => (e.checked = 0)),
              i.refetchEvents();
          }),
        B &&
          B.forEach((e) => {
            e.addEventListener("click", () => {
              document.querySelectorAll(".input-filter:checked").length <
              document.querySelectorAll(".input-filter").length
                ? (V.checked = !1)
                : (V.checked = !0),
                i.refetchEvents();
            });
          }),
        void e.config.onChange.push(function (e) {
          i.changeView(i.view.type, moment(e[0]).format("YYYY-MM-DD")),
            s(),
            g.classList.remove("show"),
            b.classList.remove("show");
        })
      );
    }
  });
