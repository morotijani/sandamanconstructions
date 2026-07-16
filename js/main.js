document.addEventListener('DOMContentLoaded', function () {

  /* --- Header scroll state --- */
  var header = document.querySelector('.site-header');
  function onScroll(){
    if (!header) return;
    if (window.scrollY > 40) header.classList.add('is-scrolled');
    else header.classList.remove('is-scrolled');
  }
  document.addEventListener('scroll', onScroll, { passive:true });
  onScroll();

  /* --- Mobile nav toggle --- */
  var toggle = document.querySelector('.nav-toggle');
  var navList = document.querySelector('.nav-list');
  if (toggle && navList) {
    toggle.addEventListener('click', function(){
      navList.classList.toggle('is-open');
      var expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
    });
    navList.querySelectorAll('a').forEach(function(a){
      a.addEventListener('click', function(){ navList.classList.remove('is-open'); });
    });
  }

  /* --- Reveal on scroll --- */
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length){
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if (entry.isIntersecting){
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold:0.15 });
    revealEls.forEach(function(el){ io.observe(el); });
  } else {
    revealEls.forEach(function(el){ el.classList.add('is-visible'); });
  }

  /* --- Dashboard gauge fill animation ---
     Each .gauge has data-value (0-100) driving stroke-dashoffset of .gauge-fill
     circumference = 251.2 (r=40 semicircle-ish arc length precomputed in markup) */
  var gauges = document.querySelectorAll('.gauge');
  if (gauges.length){
    var gaugeIO = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if (!entry.isIntersecting) return;
        var g = entry.target;
        var fill = g.querySelector('.gauge-fill');
        var val = parseFloat(g.getAttribute('data-value')) || 0;
        var circumference = parseFloat(fill.getAttribute('data-circumference')) || 251.2;
        var offset = circumference - (circumference * (val/100));
        requestAnimationFrame(function(){
          fill.style.strokeDashoffset = offset;
        });
        animateCount(g);
        gaugeIO.unobserve(g);
      });
    }, { threshold:0.4 });
    gauges.forEach(function(g){ gaugeIO.observe(g); });
  }

  function animateCount(g){
    var target = g.querySelector('.gauge-value');
    if (!target) return;
    var end = parseFloat(target.getAttribute('data-count'));
    var suffix = target.getAttribute('data-suffix') || '';
    if (isNaN(end)) return;
    var duration = 1400, start = null;
    function step(ts){
      if (!start) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      var current = Math.round(end * eased);
      target.textContent = current + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else target.textContent = end + suffix;
    }
    requestAnimationFrame(step);
  }

  /* --- Project filter (projects.html) --- */
  var filterBtns = document.querySelectorAll('.filter-btn');
  var projectCards = document.querySelectorAll('[data-category]');
  if (filterBtns.length && projectCards.length){
    filterBtns.forEach(function(btn){
      btn.addEventListener('click', function(){
        filterBtns.forEach(function(b){ b.classList.remove('is-active'); });
        btn.classList.add('is-active');
        var cat = btn.getAttribute('data-filter');
        projectCards.forEach(function(card){
          var match = cat === 'all' || card.getAttribute('data-category') === cat;
          card.style.display = match ? '' : 'none';
        });
      });
    });
  }

  /* --- Contact form (AJAX submission) --- */
  var form = document.getElementById('contact-form');
  if (form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      var submitBtn = form.querySelector('button[type="submit"]');
      var originalBtnText = submitBtn.innerHTML;
      submitBtn.innerHTML = 'Submitting...';
      submitBtn.disabled = true;

      var formData = new FormData(form);

      fetch('api/submit_contact.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          var success = document.querySelector('.form-success');
          if (success) {
            success.querySelector('span').textContent = data.message;
            success.classList.add('is-visible');
          }
          form.reset();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        alert('An error occurred. Please try again.');
        console.error(error);
      })
      .finally(() => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
      });
    });
  }

});
