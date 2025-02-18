// Copied from Tailwind Typography.
const hexToRgb = (hex) => {
	if (typeof hex !== 'string' || hex.length === 0) {
		return hex;
	}

	hex = hex.replace('#', '');
	hex = hex.length === 3 ? hex.replace(/./g, '$&$&') : hex;
	const r = parseInt(hex.substring(0, 2), 16);
	const g = parseInt(hex.substring(2, 4), 16);
	const b = parseInt(hex.substring(4, 6), 16);
	return `${r} ${g} ${b}`;
};

module.exports = {
	theme: {
		extend: {
			typography: (theme) => ({
				/**
				 * Tailwind Typography’s default styles are opinionated, and
				 * you may need to override them if you have mockups to
				 * replicate. You can view the default modifiers here:
				 *
				 * https://github.com/tailwindlabs/tailwindcss-typography/blob/master/src/styles.js
				 */

				DEFAULT: {
					css: [
						{
							/**
							 * By default, max-width is set to 65 characters.
							 * This is a good default for readability, but
							 * often in conflict with client-supplied designs.
							 * A value of false removes the max-width property.
							 */
							maxWidth: false,

							/**
							 * Tailwind Typography uses the font weights 400
							 * through 900. If you’re not using a variable font,
							 * you may need to limit the number of supported
							 * weights. Below are all of the default weights,
							 * ready to be overridden.
							 */
							// a: {
							// 	fontWeight: '500',
							// },
							// strong: {
							// 	fontWeight: '600',
							// },
							// 'ol > li::marker': {
							// 	fontWeight: '400',
							// },
							// dt: {
							// 	fontWeight: '600',
							// },
							// blockquote: {
							// 	fontWeight: '500',
							// },
							// h1: {
							// 	fontWeight: '800',
							// },
							// 'h1 strong': {
							// 	fontWeight: '900',
							// },
							// h2: {
							// 	fontWeight: '700',
							// },
							// 'h2 strong': {
							// 	fontWeight: '800',
							// },
							// h3: {
							// 	fontWeight: '600',
							// },
							// 'h3 strong': {
							// 	fontWeight: '700',
							// },
							// h4: {
							// 	fontWeight: '600',
							// },
							// 'h4 strong': {
							// 	fontWeight: '700',
							// },
							// kbd: {
							// 	fontWeight: '500',
							// },
							// code: {
							// 	fontWeight: '600',
							// },
							// pre: {
							// 	fontWeight: '400',
							// },
							// 'thead th': {
							// 	fontWeight: '600',
							// },
						},
					],
				},

				/**
				 * By default, _tw uses Tailwind Typography’s Neutral gray
				 * scale. If you are adapting an existing design and you need
				 * to set specific colors throughout, you can do so here. In
				 * your `./theme/functions.php file, you will need to replace
				 * `prose-neutral` with `prose-tw`.
				 */
				tw: {
					css: {
						'--tw-prose-body': theme('colors.foreground'),
						'--tw-prose-headings': theme('colors.foreground'),
						'--tw-prose-lead': theme('colors.foreground'),
						'--tw-prose-links': theme('colors.primary'),
						'--tw-prose-bold': theme('colors.foreground'),
						'--tw-prose-counters': theme('colors.primary'),
						'--tw-prose-bullets': theme('colors.primary'),
						'--tw-prose-hr': theme('colors.foreground'),
						'--tw-prose-quotes': theme('colors.foreground'),
						'--tw-prose-quote-borders': theme('colors.primary'),
						'--tw-prose-captions': theme('colors.foreground'),
						'--tw-prose-kbd': theme('colors.foreground'),
						'--tw-prose-kbd-shadows': hexToRgb(
							theme('colors.foreground')
						),
						'--tw-prose-code': theme('colors.foreground'),
						'--tw-prose-pre-code': theme('colors.background'),
						'--tw-prose-pre-bg': theme('colors.foreground'),
						'--tw-prose-th-borders': theme('colors.foreground'),
						'--tw-prose-td-borders': theme('colors.foreground'),
						'--tw-prose-invert-body': theme('colors.background'),
						'--tw-prose-invert-headings':
							theme('colors.background'),
						'--tw-prose-invert-lead': theme('colors.background'),
						'--tw-prose-invert-links': theme('colors.primary'),
						'--tw-prose-invert-bold': theme('colors.background'),
						'--tw-prose-invert-counters': theme('colors.primary'),
						'--tw-prose-invert-bullets': theme('colors.primary'),
						'--tw-prose-invert-hr': theme('colors.background'),
						'--tw-prose-invert-quotes': theme('colors.background'),
						'--tw-prose-invert-quote-borders':
							theme('colors.primary'),
						'--tw-prose-invert-captions':
							theme('colors.background'),
						'--tw-prose-invert-kbd': theme('colors.background'),
						'--tw-prose-invert-kbd-shadows': hexToRgb(
							theme('colors.background')
						),
						'--tw-prose-invert-code': theme('colors.foreground'),
						'--tw-prose-invert-pre-code':
							theme('colors.background'),
						'--tw-prose-invert-pre-bg': 'rgb(0 0 0 / 50%)',
						'--tw-prose-invert-th-borders':
							theme('colors.background'),
						'--tw-prose-invert-td-borders':
							theme('colors.background'),
					},
				},
			}),
			screens: {
				xs: '370px',
				md: '798px',
				xl: '1283px',
			},
			backgroundSize: {
				auto: 'auto',
				cover: 'cover',
				contain: 'contain',
				'50%': '50%',
				16: '4rem',
				'27%': '27%',
			},
		},
		gridTemplateColumns: {
			24: 'repeat(24, minmax(0, 1fr))',
			23: 'repeat(23, minmax(0, 1fr))',
			22: 'repeat(22, minmax(0, 1fr))',
			21: 'repeat(21, minmax(0, 1fr))',
			20: 'repeat(20, minmax(0, 1fr))',
			19: 'repeat(19, minmax(0, 1fr))',
			18: 'repeat(18, minmax(0, 1fr))',
			17: 'repeat(17, minmax(0, 1fr))',
			16: 'repeat(16, minmax(0, 1fr))',
			15: 'repeat(15, minmax(0, 1fr))',
			14: 'repeat(14, minmax(0, 1fr))',
			13: 'repeat(13, minmax(0, 1fr))',
			12: 'repeat(12, minmax(0, 1fr))',
			11: 'repeat(11, minmax(0, 1fr))',
			10: 'repeat(10, minmax(0, 1fr))',
			9: 'repeat(9, minmax(0, 1fr))',
			8: 'repeat(8, minmax(0, 1fr))',
			7: 'repeat(7, minmax(0, 1fr))',
			6: 'repeat(6, minmax(0, 1fr))',
			5: 'repeat(5, minmax(0, 1fr))',
			4: 'repeat(4, minmax(0, 1fr))',
			3: 'repeat(3, minmax(0, 1fr))',
			2: 'repeat(2, minmax(0, 1fr))',
			1: 'repeat(1, minmax(0, 1fr))',
		},
		gridColumn: {
			'span-4': 'span 4 / span 4',
			'span-5': 'span 5 / span 5',
			'span-6': 'span 6 / span 6',
			'span-7': 'span 7 / span 7',
			'span-8': 'span 8 / span 8',
			'span-9': 'span 9 / span 9',
			'span-10': 'span 10 / span 10',
			'span-11': 'span 11 / span 11',
			'span-12': 'span 12 / span 12',
			'span-13': 'span 13 / span 13',
			'span-14': 'span 14 / span 14',
			'span-15': 'span 15 / span 15',
			'span-16': 'span 16 / span 16',
			'span-17': 'span 17 / span 17',
			'span-18': 'span 18 / span 18',
			'span-19': 'span 19 / span 19',
			'span-20': 'span 20 / span 20',
			'span-21': 'span 21 / span 21',
			'span-22': 'span 22 / span 22',
			'span-23': 'span 23 / span 23',
			'span-24': 'span 24 / span 24',
		},
	},
};
