<template lang="pug">
   ul.nav
        li.nav__item.nav__item_active
          a(href="#") Главная
        li.nav__item 
          a(href="#") Новостройки
        li.nav__item 
          a(href="#") Застройщики
        li.nav__item 
          a(href="#") Ипотека
</template>
<style lang="scss">
.nav {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  list-style: none;
  padding: 0;
  @media screen and (max-width: $screen-xl) {
    flex-direction: column;
  }
  &__item {
    margin-left: 32px;

    &:hover {
      color: $font-hover-color;
      cursor: pointer;
    }

    &_active {
      color: $font-hover-color;
    }

    &_selectable {
      display: flex;
      justify-content: flex-start;
      align-items: center;

      &::after {
        width: 1em;
        height: 1em;
        content: '';
        background: url('../../../images/expand.svg') no-repeat center center;
        display: block;
        margin-left: 8px;
      }
    }

    a,
    a.text:active,
    a.text:hover,
    a.text {
      color: inherit;
      text-decoration: inherit;
    }
  }

  &__item:first-child {
    margin-left: 0;
  }
}
</style>
