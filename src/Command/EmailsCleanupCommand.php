<?php

namespace App\Command;

use App\Repository\ProjectRepository;
use App\Utils\EmailsCleanupService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EmailsCleanupCommand extends Command
{
    const DAYS = 7; // Clear emails older than 7 days by default

    protected static $defaultName = 'app:emails:cleanup';

    /**
     * @var EmailsCleanupService
     */
    private $emailsCleanup;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @required
     * @param EmailsCleanupService $emailsCleanup
     */
    public function getEmailsCleanupService(EmailsCleanupService $emailsCleanup)
    {
        $this->emailsCleanup = $emailsCleanup;
    }

    /**
     * @required
     * @param ProjectRepository $projectRepository
     */
    public function getProjectRepository(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Clear old email logs')
            ->addArgument('project', InputArgument::OPTIONAL, 'Specific project ID to cleanup')
            ->addOption('days', 'd', InputOption::VALUE_OPTIONAL, 'Clear emails older than number of days', self::DAYS)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $projectId = $input->getArgument('project');
        $days = $input->getOption('days');

        // NOTE: Console command doesn't check project user.
        $project = null;
        if ($projectId) {
            $project = $this->projectRepository->find($projectId);

            if (!$project) {
                $io->error(sprintf('No project ID%s found.', $projectId));
                return Command::FAILURE;
            }

            $io->note(sprintf('Project loaded: %s (ID:%s)', $project->getName(), $project->getId()));
        }

        if (!is_numeric($days)) {
            $io->error('Number of days should be an integer!');
            return Command::FAILURE;
        }

        $date = (new \DateTimeImmutable())
            ->setTime(0, 0, 0, 0)
            ->modify('-' . $days . ' days');

        $io->note(sprintf('Deleting Emails data older than %s', $date->format('c')));

        // Clear old Emails
        try {
            $this->emailsCleanup->cleanup($date, $project);
        } catch (Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        } catch (\Doctrine\DBAL\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('Emails cleared!');

        return Command::SUCCESS;
    }
}
