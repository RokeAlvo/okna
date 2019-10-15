import { HTTP, Routes } from "@/components/server/API.js";


export const Utils = Object.freeze({

    notificationSystem: {
        options: {
            show: {
                theme: "dark",
                icon: "icon-person",
                position: "topRight",
                progressBarColor: "rgb(0, 255, 184)",

                onOpening: function (instance, toast) {
                    console.info("callback abriu!");
                },
                onClosing: function (instance, toast, closedBy) {
                    console.info("closedBy: " + closedBy);
                }
            },
            error: {
                position: "topRight"
            },
            success: {
                position: "topRight"
            },
            question: {
                timeout: 20000,
                close: false,
                overlay: true,
                toastOnce: true,
                id: "question",
                zindex: 999,
                position: "center",

                onClosing: function (instance, toast, closedBy) {
                    console.info("Closing | closedBy: " + closedBy);
                },
                onClosed: function (instance, toast, closedBy) {
                    console.info("Closed | closedBy: " + closedBy);
                }
            }
        }
    },

    helpers: {
        //n- кол-во элементов . Titles массив из 3х эл-ов [1, 2, много]
        FNumber(n, titles) {
            let cases = [2, 0, 1, 1, 1, 2];
            return titles[(n % 100 > 4 && n % 100 < 20) ? 2 : cases[Math.min(n % 10, 5)]];
        },

        FSum(p, c) {
            const unity = ((0.1075 / 12) * Math.pow((1 + (0.1075 / 12)), c * 12))
                / (Math.pow((1 + (0.1075 / 12)), c * 12) - 1)
            return p / unity
        },

        FPay(s, c) {
            const unity = ((0.1075 / 12) * Math.pow((1 + (0.1075 / 12)), c * 12))
                / (Math.pow((1 + (0.1075 / 12)), c * 12) - 1)
            return s * unity
        },

        validate(e, el, phone, izitoast, notificationOptions) {
            if (phone) {
                let testPhone = phone.split(/[-()+_]/);

                if (
                    testPhone.filter(char => char.length).length === 0 ||
                    phone.split(/[-()+_]/).length > 6
                ) {
                    e.preventDefault();
                    let selectors = el.querySelectorAll(".input__phone")
                    el.querySelectorAll(".input__phone");
                    for (let i = 0; selectors.length > i; i++) {
                        selectors[i].classList.add("input__error");
                    }
                    izitoast.error(
                        "Введите корректный номер телефона",
                        "Ошибка",
                        notificationOptions
                    );
                    return false;

                } else {
                    el.querySelector(".input__phone").classList.remove("input__error");
                    return true;
                }
            }

            e.preventDefault();
            el.querySelector(".input__phone").classList.add("input__error");
            izitoast.error(
                "Введите корректный номер телефона",
                "Ошибка",
                notificationOptions
            );
            return false;

        },

        trimmer(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    }
});