import { h } from "preact";
import { Link } from "preact-router/match";
import style from "./style.css";

const Header = () => (
  <header class={style.header}>
    <a href="/" class={style.logo}>
      <img
        src="../../assets/casabela_logo.svg"
        alt="Casabela logo"
        height="32"
        width="32"
      />
      <h1>Casabela</h1>
    </a>
    <nav>
      <input type="checkbox" id="nav-check" />
      <div class="nav-header"></div>
      <div class="nav-btn">
        <label for="nav-check">
          <span></span>
          <span></span>
          <span></span>
        </label>
      </div>
      <div class="nav-links">
        <Link activeClassName={style.active} href="/">
          Inicio
        </Link>
        <Link activeClassName={style.active} href="/properties">
          Propiedades
        </Link>
      </div>
    </nav>
  </header>
);

export default Header;
