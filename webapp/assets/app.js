import DateTimePicker from './elements/DatetimePicker';
import './styles/app.scss';

import Swup from 'swup';
import SwupFormsPlugin from '@swup/forms-plugin';

// const swup = new Swup({
// 	cache: false,
// 	plugins: [new SwupFormsPlugin()],
// });

// window.swup = swup;

// swup.on('contentReplaced', (e) => {
// 	if (window.location.pathname === '/resume/exp') {
// 		const addNewExperienceElement = document.querySelector('#form_add_new_experience');
// 		const collectionHolder = document.querySelector('form');
// 		const prototypeTemplate = document.querySelector('#experience_prototype');

// 		const addFormToCollection = (e) => {
// 			const newContent = prototypeTemplate.innerHTML.replace(
// 				/__name__/g,
// 				collectionHolder.dataset.index
// 			);
// 			collectionHolder.innerHTML = newContent + collectionHolder.innerHTML;

// 			const deleteButton = document.querySelector(
// 				`#resume_experiences_form_experiences_${collectionHolder.dataset.index} a.experience_delete`
// 			);
// 			deleteButton.addEventListener('click', (e) => {
// 				e.preventDefault();
// 				deleteButton.parentNode.parentNode.remove();
// 			});

// 			collectionHolder.dataset.index++;
// 		};

// 		document.querySelectorAll('a.experience_delete').forEach((deleteButton) => {
// 			deleteButton.addEventListener('click', (e) => {
// 				e.preventDefault();
// 				deleteButton.parentNode.parentNode.remove();
// 			});
// 		});

// 		addNewExperienceElement.addEventListener('click', addFormToCollection);
// 	}
// });

// swup.on('willReplaceContent', (e) => {
// 	document.querySelectorAll('a.experience_delete').forEach((deleteButton) => {
// 		deleteButton.removeEventListener('click', (e) => {
// 			e.preventDefault();
// 			deleteButton.parentNode.parentNode.remove();
// 		});
// 	});
// });

customElements.define('datetime-picker', DateTimePicker, { extends: 'input' });
