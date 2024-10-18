import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { InertiaProgress } from '@inertiajs/progress';
import router from './router'; // 방금 생성한 라우터 import


class Toggle {
    constructor({ $target }) {
        // 토글 버튼의 템플릿이 될 div를 하나 생성
        this.$toggle = document.createElement("div");
        this.$toggle.style.cssText = "width: 150px; padding: 10px; margin: 10px 0; border: 2px solid gray; border-radius: 8px; text-align: center; background-color: #f0f0f0;"; // 배경색 추가
        this.$toggle.addEventListener("mouseover", () => {
            this.$toggle.style.cursor = "pointer";
            this.$toggle.style.backgroundColor = "#e0e0e0"; // 마우스 오버 시 배경색 변경
        });
        this.$toggle.addEventListener("mouseout", () => {
            this.$toggle.style.backgroundColor = "#f0f0f0"; // 마우스 아웃 시 배경색 원래대로
        });

        // 다크모드일 경우 '라이트모드로 보기', 라이트모드일 경우 '다크모드로 보기' 라고 보여줄 label을 하나 생성
        this.$label = document.createElement("label");
        this.$label.style.fontSize = "16px"; // 글자 크기 조정
        this.$label.style.fontWeight = "bold"; // 글자 두껍게
        // label과 checkbox input을 연결
        this.$label.htmlFor = "check";
        this.$label.addEventListener("mouseover", () => {
            this.$label.style.cursor = "pointer";
        });
        this.$toggle.appendChild(this.$label);

        // 다크모드일 경우 true, 라이트모드일 경우 false로 체크할 checkbox 타입의 input을 하나 생성
        this.$input = document.createElement("input");
        this.$input.type = "checkbox";
        this.$input.id = "check";
        this.$input.style.cssText = "display: none";
        this.$toggle.appendChild(this.$input);

        $target.appendChild(this.$toggle);

        // OS의 다크모드 활성화 여부에 따라 label과 input의 초깃값 및 body의 data-theme 속성을 설정
        let $theme = document.body.dataset.theme;
        if (!$theme) {
            // OS의 다크모드가 활성화되어 있는 경우
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                $theme = "dark";
                this.$label.innerText = "☀ 라이트모드로 보기";
                this.$input.checked = true;   
            }
            // OS의 다크모드가 비활성화되어 있는 경우
            else {
                $theme = "light";
                this.$label.innerText = "🌙 다크모드로 보기";
                this.$input.checked = false;
            }
            document.body.dataset.theme = $theme;
        }

        this.render();
    }

    render() {
        // 토글 버튼을 클릭할 경우, checkbox input의 값에 따라 적절하게 body의 data-theme 속성 및 label 텍스트를 수정
        this.$toggle.addEventListener("click", (e) => {
            // 다크모드일 경우 (checkbox input의 값이 true일 경우)
            if (this.$input.checked) {
                document.body.dataset.theme = "dark";
                this.$label.innerText = "☀ 라이트모드로 보기";
            }
            // 라이트모드일 경우 (checkbox input의 값이 false일 경우)
            else {
                document.body.dataset.theme = "light";
                this.$label.innerText = "🌙 다크모드로 보기";
            }
        }); 
    }
}

// Toggle 클래스를 사용하여 다크모드 기능을 초기화
const toggle = new Toggle({ $target: document.body });

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(router) // 라우터 사용
            .mount(el);
    },
});

InertiaProgress.init();
