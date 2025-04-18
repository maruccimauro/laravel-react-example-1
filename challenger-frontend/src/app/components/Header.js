"use client";

import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import NavDropdown from "react-bootstrap/NavDropdown";

export default function Header() {
    return (
        <Container id="header" fluid>
            <Navbar expand="lg" className="">
                <Container>
                    <Navbar.Brand>Challenger</Navbar.Brand>
                    <Navbar.Toggle
                        className="header-toggle"
                        aria-controls="basic-navbar-nav"
                    />
                    <Navbar.Collapse id="basic-navbar-nav">
                        <Nav className="me-auto">
                            <Nav.Link className="header-link" href="#home">
                                <span class="material-symbols-outlined">
                                    account_circle
                                </span>
                                login
                            </Nav.Link>
                            <Nav.Link className="header-link" href="#home">
                                <span class="material-symbols-outlined">
                                    account_circle_off
                                </span>
                                logout
                            </Nav.Link>
                            {/* <Nav.Link href="#link">Link</Nav.Link>
                        <NavDropdown
                            className="header-link"
                            title="Dropdown"
                            id="basic-nav-dropdown"
                        >
                            <NavDropdown.Item href="#action/3.1">
                                Action
                            </NavDropdown.Item>
                            <NavDropdown.Item href="#action/3.2">
                                Another action
                            </NavDropdown.Item>
                            <NavDropdown.Item href="#action/3.3">
                                Something
                            </NavDropdown.Item>
                            <NavDropdown.Divider />
                            <NavDropdown.Item href="#action/3.4">
                                Separated link
                            </NavDropdown.Item>
                        </NavDropdown> */}
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
        </Container>
    );
}
