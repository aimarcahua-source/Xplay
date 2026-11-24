(() => {
  'use strict';

  const body = document.body;
  const menuButton = document.querySelector('.fb-menu-toggle');
  const nav = document.getElementById('site-navigation');
  const closeButton = nav ? nav.querySelector('.fb-menu-close') : null;
  const backdrop = document.querySelector('[data-fb-menu-backdrop]');
  const categoryMenu = document.querySelector('.fb-category-menu');
  const mobileQuery = window.matchMedia('(max-width: 980px)');

  const isMenuOpen = () => Boolean(
    menuButton && menuButton.getAttribute('aria-expanded') === 'true'
  );

  const setNavigationInert = (inert) => {
    if (!nav) return;

    nav.inert = Boolean(inert);
    if (inert) {
      nav.setAttribute('inert', '');
    } else {
      nav.removeAttribute('inert');
    }
  };

  const getFocusableItems = () => {
    if (!nav) return [];

    return Array.from(nav.querySelectorAll(
      'button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    )).filter((element) => element.getClientRects().length > 0);
  };

  const updateMenuMode = () => {
    if (!menuButton || !nav) return;

    if (mobileQuery.matches) {
      if (categoryMenu) categoryMenu.removeAttribute('open');
      nav.setAttribute('role', 'dialog');
      nav.setAttribute('aria-modal', 'true');
      nav.setAttribute('aria-hidden', String(!isMenuOpen()));
      setNavigationInert(!isMenuOpen());
      return;
    }

    menuButton.setAttribute('aria-expanded', 'false');
    const label = menuButton.querySelector('.screen-reader-text');
    if (label && window.feedbuzzData) label.textContent = feedbuzzData.menuOpen;
    nav.classList.remove('is-open');
    nav.removeAttribute('role');
    nav.removeAttribute('aria-modal');
    nav.removeAttribute('aria-hidden');
    setNavigationInert(false);
    body.classList.remove('fb-menu-open');
    if (backdrop) backdrop.hidden = true;
  };

  const setMenu = (open, restoreFocus = true) => {
    if (!menuButton || !nav) return;

    const shouldOpen = Boolean(open && mobileQuery.matches);
    menuButton.setAttribute('aria-expanded', String(shouldOpen));
    nav.classList.toggle('is-open', shouldOpen);
    body.classList.toggle('fb-menu-open', shouldOpen);
    nav.setAttribute('aria-hidden', String(!shouldOpen));
    setNavigationInert(!shouldOpen);

    if (backdrop) backdrop.hidden = !shouldOpen;

    const label = menuButton.querySelector('.screen-reader-text');
    if (label && window.feedbuzzData) {
      label.textContent = shouldOpen ? feedbuzzData.menuClose : feedbuzzData.menuOpen;
    }

    if (shouldOpen) {
      window.requestAnimationFrame(() => {
        if (closeButton) closeButton.focus();
      });
    } else if (restoreFocus && document.contains(menuButton)) {
      menuButton.focus();
    }
  };

  if (menuButton && nav) {
    menuButton.addEventListener('click', () => setMenu(!isMenuOpen()));
    if (closeButton) closeButton.addEventListener('click', () => setMenu(false));
    if (backdrop) backdrop.addEventListener('click', () => setMenu(false));

    nav.addEventListener('keydown', (event) => {
      if (!mobileQuery.matches || !isMenuOpen()) return;

      if (event.key === 'Escape') {
        event.preventDefault();
        setMenu(false);
        return;
      }

      if (event.key !== 'Tab') return;

      const focusableItems = getFocusableItems();
      if (!focusableItems.length) {
        event.preventDefault();
        return;
      }

      const firstItem = focusableItems[0];
      const lastItem = focusableItems[focusableItems.length - 1];

      if (event.shiftKey && document.activeElement === firstItem) {
        event.preventDefault();
        lastItem.focus();
      } else if (!event.shiftKey && document.activeElement === lastItem) {
        event.preventDefault();
        firstItem.focus();
      }
    });
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && isMenuOpen()) {
      event.preventDefault();
      setMenu(false);
    }
  });

  document.addEventListener('focusin', (event) => {
    if (!mobileQuery.matches || !isMenuOpen() || !nav || nav.contains(event.target)) return;

    const focusableItems = getFocusableItems();
    const focusTarget = focusableItems[0] || closeButton;
    if (focusTarget) focusTarget.focus();
  });

  const handleViewportChange = () => updateMenuMode();
  if (typeof mobileQuery.addEventListener === 'function') {
    mobileQuery.addEventListener('change', handleViewportChange);
  } else {
    mobileQuery.addListener(handleViewportChange);
  }
  updateMenuMode();

  if (categoryMenu) {
    const categorySummary = categoryMenu.querySelector('summary');
    const categoryTriggerLinks = Array.from(document.querySelectorAll('[data-fb-open-categories="true"]'));

    const syncCategoryTriggerState = () => {
      categoryTriggerLinks.forEach((link) => {
        link.setAttribute('aria-expanded', categoryMenu.open ? 'true' : 'false');
      });
    };

    const openCategoryMenu = () => {
      categoryMenu.setAttribute('open', '');
      syncCategoryTriggerState();

      const firstCategoryLink = categoryMenu.querySelector('.fb-category-menu-list a');
      if (firstCategoryLink) {
        window.requestAnimationFrame(() => firstCategoryLink.focus());
      } else if (categorySummary) {
        window.requestAnimationFrame(() => categorySummary.focus());
      }
    };

    categoryTriggerLinks.forEach((link) => {
      link.addEventListener('click', (event) => {
        event.preventDefault();
        openCategoryMenu();
      });
    });

    document.addEventListener('click', (event) => {
      if (categoryMenu.open && !categoryMenu.contains(event.target)) {
        categoryMenu.removeAttribute('open');
        syncCategoryTriggerState();
      }
    });

    categoryMenu.addEventListener('toggle', () => {
      syncCategoryTriggerState();
    });

    categoryMenu.addEventListener('focusout', (event) => {
      if (!categoryMenu.open || categoryMenu.contains(event.relatedTarget)) return;

      categoryMenu.removeAttribute('open');
      syncCategoryTriggerState();
    });

    categoryMenu.addEventListener('keydown', (event) => {
      if (event.key !== 'Escape' || !categoryMenu.open) return;

      event.preventDefault();
      categoryMenu.removeAttribute('open');
      syncCategoryTriggerState();
      if (categorySummary) categorySummary.focus();
    });

    syncCategoryTriggerState();
  }

  const headerSearch = document.querySelector('.fb-header-search .fb-search-form input[type="search"]');
  const isEditableElement = (element) => Boolean(
    element && (
      element.tagName === 'INPUT' ||
      element.tagName === 'TEXTAREA' ||
      element.tagName === 'SELECT' ||
      element.isContentEditable
    )
  );

  document.addEventListener('keydown', (event) => {
    if (!headerSearch) return;

    const wantsCommandSearch = (event.key && event.key.toLowerCase() === 'k' && (event.metaKey || event.ctrlKey));
    const wantsSlashSearch = event.key === '/' && !event.metaKey && !event.ctrlKey && !event.altKey;

    if (!wantsCommandSearch && !wantsSlashSearch) return;
    if (wantsSlashSearch && isEditableElement(event.target)) return;

    event.preventDefault();
    headerSearch.focus();
    headerSearch.select();
  });

  const primaryMenu = nav ? nav.querySelector(':scope > .fb-nav-list') : null;

  if (primaryMenu) {
    /*
     * "Tüm kategoriler" is the desktop overflow bucket. When the user has
     * already created that item in Appearance > Menus we reuse it instead of
     * creating a second control. Only items that cannot fit on the visible row
     * are moved into its submenu.
     */
    let overflowItem = primaryMenu.querySelector(':scope > .fb-open-all-categories');
    let overflowButton = overflowItem
      ? overflowItem.querySelector(':scope > a, :scope > button')
      : null;
    const hasManagedOverflowItem = Boolean(overflowItem && overflowButton);
    const originalItems = Array.from(primaryMenu.children).filter((item) => item !== overflowItem);
    const overflowMenu = document.createElement('ul');
    let resizeTimer = 0;
    let fitFrame = 0;

    if (!overflowItem) {
      overflowItem = document.createElement('li');
      overflowItem.className = 'menu-item menu-item-has-children fb-nav-overflow-item';
      overflowButton = document.createElement('button');
      overflowButton.type = 'button';
      overflowButton.innerHTML = '<span class="fb-nav-overflow-icon" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span><span class="fb-nav-overflow-label"></span>';
      const overflowVisibleLabel = window.feedbuzzData && feedbuzzData.allCategories
        ? feedbuzzData.allCategories
        : '';
      const overflowText = overflowButton.querySelector('.fb-nav-overflow-label');
      if (overflowText) overflowText.textContent = overflowVisibleLabel;
      overflowItem.appendChild(overflowButton);
      primaryMenu.appendChild(overflowItem);
    }

    overflowItem.classList.add('menu-item-has-children', 'fb-nav-overflow-item');
    overflowButton.classList.add('fb-nav-overflow-toggle');
    overflowButton.removeAttribute('data-fb-open-categories');
    overflowButton.setAttribute('data-fb-overflow-menu', 'true');
    overflowButton.setAttribute('aria-haspopup', 'true');
    overflowButton.setAttribute('aria-expanded', 'false');
    overflowButton.setAttribute(
      'aria-label',
      window.feedbuzzData && feedbuzzData.menuMore ? feedbuzzData.menuMore : overflowVisibleLabel
    );

    /* Remove a WordPress child submenu from this sentinel if one was assigned. */
    Array.from(overflowItem.children).forEach((child) => {
      if (child !== overflowButton && child.matches && child.matches('.sub-menu')) child.remove();
    });

    overflowMenu.className = 'sub-menu fb-nav-overflow-menu';
    overflowItem.appendChild(overflowMenu);
    overflowItem.hidden = false;

    const revealPrimaryMenu = () => {
      primaryMenu.classList.add('fb-nav-fit-ready');
    };

    const closeOverflowMenu = (restoreFocus = false) => {
      overflowItem.classList.remove('is-open');
      overflowButton.setAttribute('aria-expanded', 'false');
      if (restoreFocus && document.contains(overflowButton)) overflowButton.focus();
    };

    const restoreMenuItems = () => {
      originalItems.forEach((item) => {
        primaryMenu.insertBefore(item, overflowItem);
      });
      closeOverflowMenu();
    };

    const applyDesktopMenuFit = () => {
      primaryMenu.classList.add('fb-nav-is-fitting');
      restoreMenuItems();
      overflowItem.hidden = false;

      if (mobileQuery.matches) {
        overflowItem.hidden = true;
        primaryMenu.classList.remove('fb-nav-is-fitting');
        revealPrimaryMenu();
        return;
      }

      const availableWidth = primaryMenu.clientWidth;
      if (!availableWidth) {
        primaryMenu.classList.remove('fb-nav-is-fitting');
        revealPrimaryMenu();
        return;
      }

      const menuStyle = window.getComputedStyle(primaryMenu);
      const gap = parseFloat(menuStyle.columnGap) || 0;
      const overflowWidth = overflowItem.getBoundingClientRect().width;
      const itemWidths = originalItems.map((item) => item.getBoundingClientRect().width);
      let usedWidth = overflowWidth;
      let keepCount = 0;

      for (const width of itemWidths) {
        const nextWidth = usedWidth + gap + width;
        if (nextWidth > availableWidth + 1) break;
        usedWidth = nextWidth;
        keepCount += 1;
      }

      originalItems.slice(keepCount).forEach((item) => {
        overflowMenu.appendChild(item);
      });

      /*
       * Keep a managed "Tüm kategoriler" item visible even when everything
       * fits. A generated fallback control is only needed when there are hidden
       * items, so hide it when its submenu is empty.
       */
      if (!hasManagedOverflowItem && overflowMenu.children.length === 0) {
        overflowItem.hidden = true;
      }

      primaryMenu.classList.remove('fb-nav-is-fitting');
      revealPrimaryMenu();
    };

    const fitDesktopMenu = (immediate = false) => {
      window.cancelAnimationFrame(fitFrame);

      if (immediate) {
        applyDesktopMenuFit();
        return;
      }

      fitFrame = window.requestAnimationFrame(applyDesktopMenuFit);
    };

    const scheduleMenuFit = () => {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(fitDesktopMenu, 80);
    };

    overflowButton.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (!overflowMenu.children.length) return;
      const willOpen = !overflowItem.classList.contains('is-open');
      overflowItem.classList.toggle('is-open', willOpen);
      overflowButton.setAttribute('aria-expanded', String(willOpen));
    });

    overflowItem.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && overflowItem.classList.contains('is-open')) {
        event.preventDefault();
        closeOverflowMenu(true);
      }
    });

    document.addEventListener('click', (event) => {
      if (!overflowItem.contains(event.target)) closeOverflowMenu();
    });

    window.addEventListener('resize', scheduleMenuFit, { passive: true });

    if (typeof mobileQuery.addEventListener === 'function') {
      mobileQuery.addEventListener('change', scheduleMenuFit);
    } else {
      mobileQuery.addListener(scheduleMenuFit);
    }

    fitDesktopMenu(true);
  }

  const tickerTrack = document.querySelector('[data-ticker-track]');
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (tickerTrack && !reducedMotion) {
    const items = Array.from(tickerTrack.children);

    if (items.length > 1) {
      const gap = parseFloat(window.getComputedStyle(tickerTrack).columnGap) || 0;
      const originalWidth = items.reduce(
        (sum, item) => sum + item.getBoundingClientRect().width,
        0
      ) + (items.length - 1) * gap;

      items.forEach((item) => {
        const clone = item.cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        clone.querySelectorAll('a, button, input, select, textarea, [tabindex]').forEach((element) => {
          element.setAttribute('tabindex', '-1');
        });
        if (clone.matches('a, button, input, select, textarea, [tabindex]')) {
          clone.setAttribute('tabindex', '-1');
        }
        tickerTrack.appendChild(clone);
      });

      tickerTrack.style.setProperty('--fb-ticker-distance', `${originalWidth}px`);
      tickerTrack.classList.add('is-animated');
    }
  }


  const showcase = document.querySelector('[data-fb-showcase]');

  if (showcase) {
    const slides = Array.from(showcase.querySelectorAll('[data-fb-showcase-slide]'));
    const dots = Array.from(showcase.querySelectorAll('[data-fb-showcase-dot]'));
    const previousButton = showcase.querySelector('[data-fb-showcase-prev]');
    const nextButton = showcase.querySelector('[data-fb-showcase-next]');
    let activeSlide = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));

    const setActiveSlide = (index) => {
      if (!slides.length) return;

      activeSlide = (index + slides.length) % slides.length;

      slides.forEach((slide, slideIndex) => {
        const isActive = slideIndex === activeSlide;
        slide.classList.toggle('is-active', isActive);
        slide.setAttribute('aria-hidden', String(!isActive));
        slide.inert = !isActive;
      });

      dots.forEach((dot, dotIndex) => {
        const isActive = dotIndex === activeSlide;
        dot.classList.toggle('is-active', isActive);
        dot.setAttribute('aria-pressed', String(isActive));
      });
    };

    if (slides.length > 1) {
      if (previousButton) {
        previousButton.addEventListener('click', () => setActiveSlide(activeSlide - 1));
      }

      if (nextButton) {
        nextButton.addEventListener('click', () => setActiveSlide(activeSlide + 1));
      }

      dots.forEach((dot) => {
        dot.addEventListener('click', () => {
          const targetIndex = Number.parseInt(dot.dataset.fbShowcaseDot || '', 10);
          if (Number.isInteger(targetIndex)) setActiveSlide(targetIndex);
        });
      });

      showcase.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
          event.preventDefault();
          setActiveSlide(activeSlide - 1);
        } else if (event.key === 'ArrowRight') {
          event.preventDefault();
          setActiveSlide(activeSlide + 1);
        }
      });
    }

    setActiveSlide(activeSlide);
  }

  document.querySelectorAll('.fb-primary-nav .menu-item-has-children > a').forEach((link) => {
    const parent = link.parentElement;
    if (!parent) return;

    link.setAttribute('aria-haspopup', 'true');
    link.setAttribute('aria-expanded', 'false');
    link.addEventListener('focus', () => link.setAttribute('aria-expanded', 'true'));
    parent.addEventListener('mouseenter', () => link.setAttribute('aria-expanded', 'true'));
    parent.addEventListener('mouseleave', () => link.setAttribute('aria-expanded', 'false'));
    parent.addEventListener('focusout', (event) => {
      if (!parent.contains(event.relatedTarget)) link.setAttribute('aria-expanded', 'false');
    });
  });

})();
