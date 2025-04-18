"use client";
import { Container } from "react-bootstrap";
export default function Main({ children }) {
    return (
        <Container fluid id="main">
            {children}
        </Container>
    );
}
