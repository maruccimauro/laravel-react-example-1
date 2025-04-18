"use client";
import styles from "../page.module.css";
import Header from "../components/Header";
import Main from "../components/Main";
import Footer from "../components/Footer";
import LoginForm from "../components/LoginForm";
import "bootstrap/dist/css/bootstrap.min.css";
export default function Home() {
    return (
        <>
            <Header></Header>
            <Main>
                <LoginForm></LoginForm>
            </Main>
            <Footer></Footer>
        </>
    );
}
