describe('page home', () => {
  it('passes', () => {
    cy.visit('https://127.0.0.1:8000/home')
  })
})

describe('page categorie', () => {
  it('passes', () => {
    cy.visit('https://127.0.0.1:8000/categories')
  })
})

/* describe('page articles', () => {
  it('passes', () => {
    cy.visit('https://127.0.0.1:8000/articles')
  })
}) */