(function(){

	$('.flex-container').waitForImages(function() {

		$('.spinner').fadeOut();

	}, $.noop, true);

	

	$(".flex-slide").each(function(){

		$(this).hover(function(){

			$(this).find('.flex-title').css({

				transform: 'rotate(0deg)',

				top: '10%'

			});

			$(this).find('.flex-Relmo').css({

				opacity: '1'

			});

            $(this).find('.flex-Relep').css({

				opacity: '1'

			});

            $(this).find('.flex-Relayn').css({

				opacity: '1'

			});

            $(this).find('.flex-Relen').css({

				opacity: '1'

			});

            $(this).find('.flex-Releem').css({

				opacity: '1'

			});

		}, function(){

			$(this).find('.flex-title').css({

				transform: 'rotate(270deg)',

				top: '15%'

			});

			$(this).find('.flex-Relmo').css({

				opacity: '0'

			});

            $(this).find('.flex-Relep').css({

				opacity: '0'

			});

            $(this).find('.flex-Relayn').css({

				opacity: '0'

			});

            $(this).find('.flex-Relen').css({

				opacity: '0'

			});

            $(this).find('.flex-Releem').css({

				opacity: '0'

			});

		})

	});

})();