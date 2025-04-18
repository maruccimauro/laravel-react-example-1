"use client";

import { Col, Container, Row } from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import { useState } from "react";
import Alert from "react-bootstrap/Alert";
import { useRouter } from "next/navigation";

export default function LoginForm() {
    const [hasError, setHasError] = useState(false);
    const [formData, setFormData] = useState({
        email: "",
        password: "",
    });
    const route = useRouter();

    function handleInputChange(e) {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    }

    async function handleSubmit(e) {
        e.preventDefault();
        setHasError(false);
        try {
            const response = await fetch(
                "http://challenger-backend.test/api/auth/login",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        email: formData.email,
                        password: formData.password,
                    }),
                }
            );

            if (!response.ok) {
                setHasError(true);
                return;
            }
            const data = await response.json();
            localStorage.setItem(
                "data",
                JSON.stringify({ token: data.token, user: data.user })
            );
            route.push("/dashboard");
        } catch (error) {
            console.error("Error al enviar la solicitud:", error);
            setHasError(true);
        }
    }

    return (
        <Container className="container-login-form">
            <Form id="login-form" onSubmit={handleSubmit}>
                <Form.Group className="mb-3" controlId="email">
                    <Form.Label>Email address</Form.Label>
                    <Form.Control
                        name="email"
                        type="email"
                        onChange={handleInputChange}
                        placeholder="Enter email"
                    />
                </Form.Group>

                <Form.Group className="mb-3" controlId="password">
                    <Form.Label>Password</Form.Label>
                    <Form.Control
                        name="password"
                        type="password"
                        onChange={handleInputChange}
                        placeholder="Password"
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    {hasError && (
                        <Form.Text className="text-muted">
                            <Alert variant="danger">
                                Error trying to log in , please try again.
                            </Alert>
                        </Form.Text>
                    )}
                </Form.Group>

                <Button variant="primary" type="submit">
                    Login
                </Button>
            </Form>
        </Container>
    );
}
