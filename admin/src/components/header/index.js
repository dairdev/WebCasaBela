import { h } from 'preact';
import { Link } from 'preact-router/match';
import style from './style.css';

const Header = () => (
	<header class={style.header}>
		<a href="/" class={style.logo}>
			<img src="../../assets/preact-logo-inverse.svg" alt="Casabela logo" height="32" width="32" />
			<h1>Casabela</h1>
		</a>
		<nav>
			<Link activeClassName={style.active} href="/">
				Inicio
			</Link>
			<Link activeClassName={style.active} href="/properties">
				Propiedades
			</Link>
		</nav>
	</header>
);

export default Header;
