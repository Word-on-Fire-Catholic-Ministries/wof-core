(() => {
  console.log('LC Loaded')
  const feats = document.querySelectorAll('[data-lc-feat-id]')
  const selectors = document.querySelectorAll('[data-lc-list-id]')

  if (feats.length < 1 || selectors.length < 1) {
    return;
  }




  selectors.forEach(sel => {
    sel.addEventListener('mouseover', evt => {
      const selectedNum = evt.target.dataset.lcListId

      if (!selectedNum) {
        return;
      }

      let newActive;

      feats.forEach(feat => {
        if (feat.dataset.lcFeatId == selectedNum) {
          newActive = feat
        }
      })

      const active = document.querySelector('.latest-content__featured-item.active')

      if (!active || !newActive) {
        return;
      }

      active.classList.remove('active')
      newActive.classList.add('active')

    })
  })

})()